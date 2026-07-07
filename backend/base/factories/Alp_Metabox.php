<?php

/**
 * Classe responsável pela geração e manutenção de Metaboxes.
 * Utiliza o plugin Meta Box.
 * @link https://metabox.io
 * 
 * @author Alpina Digital
 * @package Alpina V4
 * @since 4.0
 * 
 */
class Alp_Metabox
{
  use Alp_Metabox_Fields;
  use Alp_Metabox_Specifics;

  /**
   * Armezena o array que será utilizado pelo Meta Box para criar todos os campos no método render.
   * @see Alp_Metabox::render() 
   */
  private array $metaboxes = [];

  /**
   * Armezena os IDs de todos os post metas.
   * Há array com todos os subprefixes e '_main' e dentro deles há um array com todos os IDs registrados. 
   * @var array<string,array<int,string>> $post_metas
   */
  private array $post_metas = [];

  /**
   * Post type que está sendo trabalhado.
   */
  private string|array|null $post_type = NULL;

  /**
   * Taxonomia que está sendo trabalhada (para term meta).
   */
  private string|array|null $taxonomy = NULL;

  /**
   * Armazena o template da página, em caso do post type ser 'page'.
   */
  private bool|string $template = false;

  /**
   * Armazena se deve remover o editor de texto da página, em caso do post type ser 'page'.
   */
  private bool $remove_editor = false;

  /**
   * Armazena o prefix atual dos campos do Metabox.
   */
  private string $prefix = '';

  /**
   * Armazena o subprefix atual dos campos do Metabox.
   */
  private string $subprefix = '';

  /**
   * @var array O caminho atual onde os fields serão inseridos.
   * Quando uma box é adicionada, o caminho vai para a key fields dela.
   * Quando um group é adicionado, o caminho vai para a key fields dele. Se esse group é fechado, volta ao caminho anterior.
   */
  private array $fields_path = [];

  /**
   * @var Alp_Metabox_AutoImage Helper para buscar imagens automaticamente.
   */
  private Alp_Metabox_AutoImage $autoimage;

  /**
   * Não há um construtor. Utilize os métodos estáticos para criar as metaboxes.
   * @see Alp_Metabox::create_for_post_type() Para criar metaboxes para um post type.
   * @see Alp_Metabox::create_for_template_page() Para criar metaboxes para uma página com template específico.
   * @see Alp_Metabox::create_for_taxonomy() Para criar metaboxes para uma taxonomia (term meta).
   */
  private function __construct() {}

  /**
   * Cria uma instância de Alp_Metabox para um post type específico.
   * @param string $prefix Prefixo de metabox do post type.
   * @param string $post_type Post type que irá trabalhar.
   * 
   * @return self para encadeamento.
   */
  public static function create_for_post_type(string $prefix, string|array $post_type): self
  {
    $mb = new Alp_Metabox();
    $mb->set_prefix($prefix);
    $mb->set_post_type($post_type);
    return $mb;
  }

  /**
   * Cria uma instância de Alp_Metabox para uma página com template específico.
   * @param string $prefix Prefixo de metabox da página.
   * @param string $template Template da página.
   * @param bool $remove_editor Se é necessário remover o editor.
   * 
   * @return self para encadeamento.
   */
  public static function create_for_template_page(string $prefix, string $template, bool $remove_editor = true): self
  {
    $mb = new Alp_Metabox();
    $mb->set_prefix($prefix);
    $mb->set_post_type('page');
    $mb->set_template($template);
    $mb->set_remove_editor($remove_editor);
    return $mb;
  }

  /**
   * Cria uma instância de Alp_Metabox para uma taxonomia específica (term meta).
   * Usa a extensão MB Term Meta do Meta Box.
   * 
   * @param string $prefix Prefixo de metabox da taxonomia.
   * @param string|array $taxonomy Taxonomia(s) que irá trabalhar.
   * 
   * @return self para encadeamento.
   */
  public static function create_for_taxonomy(string $prefix, string|array $taxonomy): self
  {
    $mb = new Alp_Metabox();
    $mb->set_prefix($prefix);
    $mb->set_taxonomy($taxonomy);
    return $mb;
  }

  /**
   * @param string $subprefix O subprefix da box, que será aplicado aos seus fields.
   * @param string $title O título da box.
   * @param string|false|null $id O id da box é opcional. Se não for passado, será sanitizado do title.
   * @param string $context O contexto da box: 'normal', 'advanced' ou 'side'. Padrão: 'normal'.
   * @param string $priority A prioridade da box: 'high', 'core', 'default' ou 'low'. Padrão: 'high'.
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_box(string $subprefix, string $title, string|false|null $id = false, string $context = 'normal', string $priority = 'high'): self
  {
    if (!$id) $id = sanitize_title($title);
    $this->set_subprefix($subprefix);

    $box = [
      'id'         => $id,
      'title'      => $title,
      'context'    => $context,
      'priority'   => $priority,
      'autosave'   => true,
      'fields'     => []
    ];


    if ($this->taxonomy) {
      $box['taxonomies'] = $this->taxonomy;
    } else {
      $box['post_types'] = $this->post_type;
    }

    $this->metaboxes[] = $box;

    $this->fields_path = [array_key_last($this->metaboxes), 'fields'];

    return $this;
  }

  /**
   * Encadeia a criação de metaboxes a partir de um callable.
   * @param callable $callable Uma função que recebe um objeto Alp_Metabox como primeiro parâmetro e que também retorna um objeto Alp_Metabox.
   * @param ...$args Argumentos adicionais para a função.
   * @return self para encadeamento.
   */
  public function chain_from_callable(callable $callable, ...$args): self
  {
    $reflection = is_array($callable)
      ? new ReflectionMethod($callable[0], $callable[1])
      : new ReflectionFunction($callable);

    $parameters = $reflection->getParameters();

    $parameter = $parameters[0];
    $type = $parameter->getType();

    if (!$type || !$type instanceof ReflectionNamedType || $type->getName() !== Alp_Metabox::class) {
      throw new InvalidArgumentException(
        "O único argumento da callable deve ser do tipo " . Alp_Metabox::class . "."
      );
    }

    $returnType = $reflection->getReturnType();

    if (!$returnType || !$returnType instanceof ReflectionNamedType || $returnType->getName() !== Alp_Metabox::class) {
      throw new RuntimeException(
        "A callable deve retornar um objeto do tipo " . Alp_Metabox::class . "."
      );
    }

    return $callable($this, ...$args);
  }

  /**
   * @param string $name Name do field.
   * @param string $id ID do field, não precisa passar prefix nem subprefix. Opcional caso não queira registrar nada.
   * @param string $type O tipo do field.
   * @param int $columns Número do colunas do layout.
   * @param array<string,mixed> $more_args Mais argumentos para o field. (Sobrescrevem os anteriores se necessário.)
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_field(string $name, string $id, string $type = 'text', int $columns = 12, array $more_args = []): self
  {
    if (!$type) $type = 'text';

    if (count($this->fields_path) < 3 && $id) {
      $id = $this->apply_subprefix($id);
      $this->register_post_meta($id);
    }

    $path = &$this->get_fields_path();

    $path[] = array_merge([
      'name'    => $name,
      'id'      => $id,
      'type'    => $type,
      'columns' => $columns,
    ], $more_args);

    if ($type === 'group') {
      $index = array_key_last($path);
      $this->fields_path = [...$this->fields_path, $index, 'fields'];
    }

    return $this;
  }

  /**
   * @param string $name Name do field.
   * @param string $id ID do field, não precisa passar prefix nem subprefix.
   * @param string $group_title Como será exibido o group_title do group.
   * @param int $max_clone O número máximo de clones.
   * @param int $columns Número do colunas do layout.
   * @param array<string,mixed> $more_args
   * 
   * @return self para encadeamento.
   */
  public function add_metabox_group(string $name, string $id, string $group_title = 'Item {#}', int $max_clone = -1, int $columns = 12, array $more_args = []): self
  {
    $args = [
      'clone'         => true,
      'sort_clone'    => true,
      'collapsible'   => true,
      'default_state' => 'collapsed',
      'group_title'   => $group_title,
      'max_clone'     => $max_clone,
      'fields'        => []
    ];

    $args = array_merge($args, $more_args);

    return $this->add_metabox_field($name, $id, 'group', $columns, $args);
  }

  /**
   * Fecha um group do Meta Box para que o fluxo da caixa volte ao último nível de fields.
   * @return self para encadeamento.
   */
  public function close_metabox_group(): self
  {
    array_splice($this->fields_path, -2);
    return $this;
  }

  /**
   * Faz a lógica de mostrar ou esconder um field usando a extensão Conditional Logic do Meta Box.
   * @param string $field Campo que será usado para a lógica.
   * @param mixed $value Valor que será comparado.
   * @param string $operator Operador de comparação.
   * @param bool $hide Se false, a lógica irá mostrar o campo. Se true, irá escondê-lo.
   * 
   * @return self para encadeamento.
   */
  public function add_logic(string $field, mixed $value, string $operator = '=', $hide = false): self
  {
    $path = &$this->get_fields_path();
    $last = array_key_last($path);

    $logic = !$hide ? 'visible' : 'hidden';

    $path[$last][$logic] = [$field, $operator, $value];

    return $this;
  }

  /**
   * Renderiza todas as metaboxes.
   * @return void
   */
  public function render(): void
  {
    if ($this->template && !$this->check_template()) return;

    add_filter('rwmb_meta_boxes', function ($metaboxes) {
      $metaboxes = array_merge($metaboxes, $this->metaboxes);
      return $metaboxes;
    });
  }

  /**
   * Registra o identificador no array de post_metas para ficar mais fácil a recuperação depois.
   * @param string $id Identificador do post meta.
   * @return void
   */
  public function register_post_meta(string $id): void
  {
    $subprefix = $this->subprefix ? $this->subprefix : '_main';
    $subprefix = preg_replace('%_$%', '', $subprefix);

    $this->post_metas[$subprefix][] = $id;
  }

  /**
   * Checa se o template da página é o requisitado para exibir as metaboxes.
   * @return bool true se o template corresponde, false se não.
   */
  private function check_template(): bool
  {
    global $pagenow;
    if ($pagenow === 'post-new.php') return false;
    if (!isset($_GET['post'])) return true;

    $post_id = $_GET['post'];
    if (!$post_id) return false;

    $post_type = get_post_type($post_id);
    if ($post_type !== 'page') return false;

    $template_atual = get_page_template_slug($post_id);

    if ($template_atual !== $this->template) return false;

    if ($this->remove_editor) {
      add_action('init', function () use ($post_type) {
        remove_post_type_support($post_type, 'editor');
      });
    }
    return true;
  }

  /**
   * Aplica o prefix e subprefix num ID passado, dado que ele não tenha um ou os dois.
   * @param string $id ID sem prefix/subprefix.
   * 
   * @return string ID com tudo aplicado.
   */
  private function apply_subprefix(string $id): string
  {
    if (!preg_match("%^{$this->prefix}{$this->subprefix}%", $id)) {
      $id = $this->prefix . $this->subprefix . $id;
    }

    return $id;
  }

  /**
   * Percorre o array de metaboxes para deixá-lo no ponto de adicionar novos fields.
   * @return array Local onde estão os fields.
   */
  private function &get_fields_path(): array
  {
    $array = &$this->metaboxes;

    foreach ($this->fields_path as $key) {

      if (is_array($array) && array_key_exists($key, $array)) {
        $array = &$array[$key];
      } else {
        return [];
      }
    }

    return $array;
  }

  /**
   * GETTERS & SETTERS
   */

  public function get_post_type(): string
  {
    return $this->post_type;
  }
  public function set_post_type(string $post_type): void
  {
    $this->post_type = $post_type;
  }
  public function get_taxonomy(): string|array|null
  {
    return $this->taxonomy;
  }
  public function set_taxonomy(string|array $taxonomy): void
  {
    $this->taxonomy = $taxonomy;
  }
  public function is_taxonomy(): bool
  {
    return !empty($this->taxonomy);
  }
  public function get_template(): string|false
  {
    return $this->template;
  }
  public function set_template(string|false $template): void
  {
    $this->template = $template;
  }
  public function get_remove_editor(): bool
  {
    return $this->remove_editor;
  }
  public function set_remove_editor(bool $remove_editor): void
  {
    $this->remove_editor = $remove_editor;
  }
  public function get_prefix(): string
  {
    return $this->prefix;
  }
  public function set_prefix(string $prefix): void
  {
    if (!preg_match('%_$%', $prefix)) $prefix .= '_';
    $this->prefix = $prefix;
  }
  public function get_subprefix(): string
  {
    return $this->subprefix;
  }
  public function set_subprefix(string $subprefix): void
  {
    if ($subprefix && !preg_match('%_$%', $subprefix)) $subprefix .= '_';
    $this->subprefix = $subprefix;
  }
  public function get_metaboxes(): array
  {
    return $this->metaboxes;
  }
  /**
   * @return array<string,array>
   */
  public function get_post_metas(): array
  {
    return $this->post_metas;
  }

  /**
   * Retorna os valores dos metas de um post usando a estrutura do próprio Alp_Metabox.
   * @param int $id ID do post a serem buscados os metas.
   * @param string $subprefix Subprefix específico para buscar os metas. Passe '_main' para buscar os metas principais (sem subprefix).
   * @param array|false $autoimage Array com a configuração para a Alp_Metabox_AutoImage. Ou false para não utilizar o recurso.
   * 
   * @return array Array com os valores dos metas.
   * @see Alp_Metabox_AutoImage para ver as chaves e valores que podem ser passados no array
   */
  public function get_post_metas_values(int $id, string $subprefix = '', array|false $autoimage = []): array
  {
    if (is_bool($autoimage) && !$autoimage) $autoimage = ['autoimage' => false];

    $this->autoimage = new Alp_Metabox_AutoImage($autoimage);

    if ($subprefix) return $this->get_metas_values_by_subprefix($id, $subprefix);

    foreach ($this->post_metas as $key => $ids) {
      $values[$key] = $this->get_metas_values_by_subprefix($id, $key);
    }
    return $values;
  }

  /**
   * Retorna os valores dos metas de um termo de taxonomia.
   * @param int $term_id ID do termo.
   * @param string $subprefix Subprefix específico para buscar os metas.
   * @param array|false $autoimage Array com a configuração para a Alp_Metabox_AutoImage.
   * 
   * @return array Array com os valores dos metas.
   */
  public function get_term_metas_values(int $term_id, string $subprefix = '', array|false $autoimage = []): array
  {
    return $this->get_post_metas_values($term_id, $subprefix, $autoimage);
  }

  /**
   * Retorna os valores dos metas de um subprefixo específico.
   * Funciona tanto para posts quanto para termos de taxonomia.
   * @param int $id ID do post ou termo.
   * @param string $subprefix Subprefixo dos metas.
   * 
   * @return array
   */
  private function get_metas_values_by_subprefix(int $id, string $subprefix = ''): array
  {
    $values = [];

    if (empty($this->post_metas[$subprefix]) || !is_array($this->post_metas[$subprefix])) {
      return $values;
    }

    foreach ($this->post_metas[$subprefix] as $field) {
      if ($subprefix === '_main') $key = preg_replace("%^{$this->prefix}%", "", $field);
      else $key = preg_replace("%^.*?{$subprefix}_%", "", $field);

      // Usa get_term_meta para taxonomias, get_post_meta para posts
      if ($this->is_taxonomy()) {
        $values[$key] = get_term_meta($id, $field, false);
      } else {
        $values[$key] = get_post_meta($id, $field, false);
      }

      if (is_array($values[$key]) && count($values[$key]) === 1) {
        $values[$key] = reset($values[$key]);
      }

      $values[$key] = $this->autoimage->autoimage($key, $values[$key]);
    }
    return $values;
  }

  /**
   * @deprecated Use get_metas_values_by_subprefix() ao invés.
   */
  private function get_post_metas_values_by_subprefix(int $id, string $subprefix = ''): array
  {
    return $this->get_metas_values_by_subprefix($id, $subprefix);
  }
}
