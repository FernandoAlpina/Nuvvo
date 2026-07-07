<?php
class Alp_Blog
{
  /**
   * Retorna as últimas notícias.
   * @param int $quantidade Quantidade de notícias.
   * @param int|array|string $cat Categoria das notícias.
   * @param int|array|string $pagina Página das notícias.
   * @param array<string,mixed> $args Mais args para a montagem da query.
   * @return WP_Query Query resultante.
   */
  public static function get_ultimas(int $quantidade = 10, int|array|string $cat = 0, int $pagina = 1, array $args = []): WP_Query
  {
    $default_args = [
      'post_type' => 'post',
      'posts_per_page' => $quantidade,
      'orderby' => 'date',
      'order' => 'DESC',
      'paged' => $pagina
    ];

    if (is_array($cat)) $cat = array_map([self::class, 'get_cat_id'], $cat);
    else $cat = self::get_cat_id($cat);

    $args['category__in'] = $cat;

    $args = array_merge($default_args, $args);

    return new WP_Query($args);
  }

  /**
   * Retorna a categoria principal de um post.
   * @param int $post_id ID do post.
   * @return string Nome da categoria.
   */
  public static function get_categoria_principal(int $post_id): string
  {
    $categorias = get_the_category($post_id);

    $principais = array_filter($categorias, fn(WP_Term $c) => !$c->parent);

    if (!empty($principais)) return current($principais)->name;
    if (!empty($categorias)) return current($categorias)->name;
    return '';
  }

  /**
   * @param int $post_id
   * @param int $quantidade
   * 
   * @return WP_Query
   */
  public static function get_relacionadas(int $post_id, int $quantidade = 5): WP_Query
  {
    $categorias = get_the_category($post_id);
    $categorias = array_map(fn(WP_Term $c) => $c->term_id, $categorias);

    $mesma_categoria = new WP_Query([
      'post_type' => 'post',
      'post__not_in' => [$post_id],
      'posts_per_page' => $quantidade,
      'category__in' => $categorias,
      'orderby' => 'rand'
    ]);

    if ($mesma_categoria->post_count >= $quantidade) return $mesma_categoria;

    $geral = new WP_Query([
      'post_type' => 'post',
      'post__not_in' => [$post_id],
      'posts_per_page' => $quantidade,
      'orderby' => 'rand'
    ]);

    $mesma_categoria = wp_list_pluck($mesma_categoria->posts, 'ID');
    $geral = wp_list_pluck($geral->posts, 'ID');

    $relacionadas = array_slice(array_merge($mesma_categoria, $geral), 0, $quantidade);

    return new WP_Query([
      'post_type' => 'post',
      'post__in' => $relacionadas,
      'posts_per_page' => $quantidade,
      'orderby' => 'post__in'
    ]);
  }

  /**
   * Retorna o ID de uma categoria através do slug.	
   * @param string $cat_slug Slug da categoria.
   * @return int ID da categoria.
   */
  public static function get_cat_id(string $cat_slug): int
  {

    if (is_numeric($cat_slug)) return $cat_slug;

    $cat = get_category_by_slug($cat_slug);
    if ($cat instanceof WP_Term) return $cat->term_id;
    return 0;
  }

  /**
   * Calcula o tempo de leitura de um post.
   * @param int $post_id ID do post.
   * @param int $palavras_minuto Palavras por minuto. Ajuste conforme a necessidade.
   * @return int Tempo de leitura em minutos.
   */
  public static function calcular_tempo_leitura(int $post_id, int $palavras_minuto = 200): int
  {
    $post = get_post($post_id);
    $palavras = str_word_count(strip_tags($post->post_content));
    return ceil($palavras / $palavras_minuto);
  }

  /**
   * Retorna os links de compartilhamento de um post para Facebook, LinkedIn e WhatsApp.
   * @param int $post_id ID do post.
   * @return array Links de compartilhamento.
   */
  public static function links_share(int $post_id = 0): array
  {
    $post_url = get_permalink($post_id);
    $post_title = get_the_title($post_id);
    $post_excerpt = get_the_excerpt($post_id);

    return [
      'facebook' => "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($post_url),
      // 'linkedin' => "https://www.linkedin.com/shareArticle?url=" . urlencode($post_url) . "&title=" . urlencode($post_title) . "&summary=" . urlencode($post_excerpt),
      'whatsapp' => "https://wa.me/?text=" . urlencode($post_title . " - " . $post_url),
      'instagram' => $post_url
    ];
  }
}
