# Nuvvo Design — Frontend institucional

Site institucional da **Nuvvo Design** (by Sofá News). Frontend puro: HTML semântico, CSS moderno com design tokens, JS vanilla. Sem build step, sem framework.

**Páginas implementadas:**
- 🏠 **Home** → `index.html`
- 🛋️ **Catálogo** (hub) → `catalogo.html`
  - Listagens em `catalogo/{slug}.html`: sofas, poltronas, bancos, camas
- 📖 **A Nuvvo** (sobre / institucional) → `a-nuvvo.html`
- ✨ **Inspire-se** (galeria com filtros + lightbox) → `inspire-se.html`
- 📰 **Blog Nuvvo News** (listagem) → `blog.html`
  - Posts em `/blog/{slug}.html` (5 posts iniciais)
- ✉️ **Contato** → `contato.html`
- 🔒 **Política de Privacidade** (minuta LGPD) → `politica-de-privacidade.html`

**Componente global:** Banner de cookies LGPD em todas as páginas (`scripts/cookie-banner.js`).

✅ **Escopo 100% concluído** — 8 de 8 páginas do contrato + PDP do Sofá Pecan como referência de template (`catalogo/produto-pecan.html`).

---

## Como rodar localmente

Por usar `<script defer>` e CSS modular com paths relativos, basta servir a pasta como estática.

```powershell
# Windows (sem Python/Node) — usa o serve.ps1 incluído:
powershell -ExecutionPolicy Bypass -File serve.ps1
```

```bash
# Com Python 3
python -m http.server 8080

# Com Node
npx serve .

# Com PHP
php -S localhost:8080
```

Depois abra `http://localhost:8080`.

> Abrir o `.html` diretamente (file://) **funciona**, mas algumas CDNs (Lenis, Swiper) podem ter delays. Servir local é mais rápido.

---

## Stack

| Camada | Tecnologia | Por quê |
|---|---|---|
| Markup | HTML5 semântico | acessibilidade + SEO sem framework |
| Estilo | CSS moderno (custom properties, Grid, container queries, `clamp()`) | sem build, manutenção direta |
| Motion | CSS + IntersectionObserver + Lenis (smooth scroll) | leve, sem dependência pesada |
| Carrosséis | Swiper 11 (CDN) | maduro, A11y nativo, leve |
| Fontes | Google Fonts (Cormorant Garamond, Raleway, DM Sans) | fallbacks editoriais até Bloom/Arquitecta chegarem |

---

## Estrutura

```
.
├── index.html              # Home
├── a-nuvvo.html            # Página institucional "A Nuvvo"
├── inspire-se.html         # Galeria "Inspire-se" (filtros + lightbox)
├── catalogo.html           # Hub do Catálogo (4 categorias + diferenciais + suporte arquiteto)
├── catalogo/               # Pasta com 4 listagens por categoria + PDPs
│   ├── sofas.html          (8 produtos, subcat Retráteis/Living)
│   ├── poltronas.html      (4 placeholders)
│   ├── bancos.html         (4 produtos, subcat Bancos/Pufes)
│   ├── camas.html          (4 placeholders)
│   └── produto-pecan.html  (PDP de referência — Sofá Pecan)
├── assets/docs/            # PDFs de ficha técnica
│   └── ficha-pecan.pdf     (16 páginas)
├── politica-de-privacidade.html  # Política LGPD (MINUTA — revisar com jurídico)
├── blog.html               # Listagem do Blog Nuvvo News
├── blog/                   # Pasta com posts individuais (5 posts)
│   ├── tendencias-em-design-contemporaneo.html             (Post 1 — completo)
│   ├── guia-de-tecidos-para-estofados-de-alta-decoracao.html  (Post 2 — esqueleto)
│   ├── proporcao-e-respiro-na-sala-de-estar.html           (Post 3 — esqueleto)
│   ├── cores-e-texturas-2026-paleta-do-morar-contemporaneo.html (Post 4 — esqueleto)
│   └── como-conservar-seu-estofado-de-alta-decoracao.html     (Post 5 — esqueleto)
├── contato.html            # Página "Contato"
├── serve.ps1               # servidor HTTP estático em PowerShell (Windows)
├── README.md
├── assets/
│   └── img/                # logos, favicon, fotos do hero/produtos/galeria + designer
├── styles/
│   ├── tokens.css          # design system (cores, tipografia, espaçamento, motion)
│   ├── base.css            # reset + tipografia raiz + container + utilitários
│   ├── components.css      # header, footer, botões, cards, WhatsApp, timeline, MVV, video-block, contact cards, map, btn-wa-xl
│   ├── sections.css        # estilos das 9 seções da Home
│   ├── a-nuvvo.css         # estilos específicos da página A Nuvvo (hero, essence-text, breadcrumb)
│   ├── inspire-se.css      # estilos específicos da Inspire-se (hero curto centralizado)
│   ├── blog-listagem.css   # estilos da listagem do blog (hero, grid + featured)
│   ├── blog-post.css       # estilos do post individual (share bar sticky, paths relativos)
│   ├── politica-privacidade.css  # estilos da Política (hero, layout split sumário+corpo)
│   ├── catalogo-hub.css    # estilos do hub do catálogo (4 cards categoria + suporte arquiteto)
│   ├── catalogo-listagem.css     # estilos das 4 listagens (hero + grid)
│   └── contato.css         # estilos específicos da página Contato (hero split, CTA taupe, studio grid)
└── scripts/
    ├── main.js             # init geral: Lenis, header scroll, menu mobile, dropdown + lazy vídeo institucional (.video-block: Home + A Nuvvo)
    ├── animations.js       # reveal observer + counter + timeline draw + parallax
    ├── carousels.js        # init de Swipers (hero, featured, gallery, testi, features)
    ├── inspire-se.js       # filtros client-side + load-more + lightbox + sticky filter bar
    ├── blog-listagem.js    # filtros + load-more + transição da banner-categoria
    ├── blog-post.js        # share bar (WhatsApp/LinkedIn/FB/copy) + reading time auto
    ├── politica-privacidade.js   # scroll spy do sumário (IntersectionObserver)
    ├── cookie-banner.js    # GLOBAL — banner + modal de preferências + localStorage
    ├── catalogo-hub.js     # carrosséis do hub (diferenciais + inspire-se prévia)
    ├── catalogo-listagem.js      # filtros subcat + busca debounce + load-more
    └── contato.js          # lazy load do mapa Google (LGPD) + copiar endereço
```

---

## Sistema de design

### Cores (do Manual de Identidade Visual oficial)

| Token | Hex | Uso |
|---|---|---|
| `--color-taupe` | `#9F8D7A` | cor de assinatura — backgrounds de seção (CTA final), hover, divisores |
| `--color-cream` | `#F0EDE4` | fundo dominante do site |
| `--color-burgundy` | `#50071A` | acento extremamente pontual — ponto do logo, hover de links |
| `--color-ink` | `#1A1A1A` | texto principal |
| `--color-cream-warm` | `#E8E3D6` | superfícies elevadas (big numbers, footer, depoimentos) |
| `--color-taupe-dark` | `#7A6B5C` | hover, eyebrow, WhatsApp |

### Tipografia

| Variável | Família real | Fallback Google Fonts (em uso) |
|---|---|---|
| `--font-display` | **Bloom** (paga, ainda não disponível) | **Cormorant Garamond** |
| `--font-body` | **Raleway** | Raleway |
| `--font-tech` | **Arquitecta** (paga) | **DM Sans** |

Quando os arquivos `.woff2` da Bloom e Arquitecta chegarem, basta:
1. Colocá-los em `/assets/fonts/`.
2. Adicionar `@font-face` no topo de `base.css`.
3. As variáveis em `tokens.css` já apontam para os nomes corretos primeiro.

### Escala tipográfica

Toda fluida via `clamp()` — sem media queries para tamanho de fonte.

| Token | Mobile → Desktop |
|---|---|
| `--fs-hero` | 40px → 72px |
| `--fs-h2` | 32px → 48px |
| `--fs-big-num` | 56px → 96px |
| `--fs-body` | 16px → 17px |

---

## Decisões de design feitas durante o desenvolvimento

1. **WhatsApp flutuante em taupe-dark, não verde-padrão.** O verde `#25D366` quebrava a paleta sóbria. A solução: mantém o ícone WhatsApp reconhecível, mas em cor de marca. Hover muda pra burgundy.
2. **Hero como carrossel de 3 placeholders SVG** (não vídeo). Estrutura pronta pra trocar pelo `<video>` — instruções no comentário do HTML.
3. **CTA Final com noise CSS sutil** sobre o taupe. Evita o "bloco chapado" que cansa em áreas grandes.
4. **Cursor customizado: NÃO incluído.** Decisão consciente — agrega complexidade e marcas premium europeias (Fritz Hansen, Vitra) não usam mais.
5. **Contraste taupe/cream:** taupe **nunca** usado para body text (~2:1, abaixo de WCAG AA). Apenas para backgrounds, hover, divisores e títulos ≥ 36px. Body sempre `--color-ink` sobre cream (~16:1).
6. **Grid do catálogo é assimétrico no desktop** (cards 1 e 4 mais altos, 2 e 3 menores e centralizados) — referência editorial.
7. **Header transparente sobre o hero, vira cream com blur ao scrollar.** Logo e nav adaptam cor automaticamente.
8. **Counter animado** dos big numbers respeita locale `pt-BR` (vírgula como decimal, ponto como milhar).
9. **`prefers-reduced-motion`** desliga Lenis, reveals e counters — acessibilidade real.

---

## Customizando a página "A Nuvvo"

### Ocultar a seção de vídeo institucional
A seção tem um atributo de controle. No `a-nuvvo.html`, encontre:

```html
<section class="section video-section" data-video-available="true" ...>
```

Troque `"true"` por `"false"` — a seção inteira fica oculta via CSS (`.section[data-video-available="false"] { display: none; }`).

### Ativar o vídeo (quando disponível)
1. Coloque o atributo `data-video-available="true"` (default).
2. Configure o `<button class="video-block">` com os atributos:
   - `data-video-src="..."` — URL do embed (YouTube/Vimeo) ou arquivo local (MP4)
   - `data-video-type="iframe"` (YouTube/Vimeo) **ou** `"mp4"` (arquivo local)
   - `data-video-poster="assets/img/SEU-POSTER.jpg"` — imagem de capa
3. Atualize o `<img class="video-block__poster" src="..." alt="">` com o mesmo poster.
4. Remova o texto `"Vídeo institucional em breve"` em `.video-block__label` (ou troque por outra label).

Exemplos de `data-video-src`:
- **YouTube**: `https://www.youtube.com/embed/SEU_VIDEO_ID`
- **Vimeo**:   `https://player.vimeo.com/video/SEU_VIDEO_ID`
- **MP4 local**: `assets/video/institucional.mp4` (também precisa de `data-video-type="mp4"`)

### Editar marcos da timeline
No `a-nuvvo.html`, procure `<ol class="timeline">`. Cada marco é um `<li class="timeline__item">` com:
- `.timeline__year` — ano (Bloom grande)
- `.timeline__title` — título do marco
- `.timeline__desc` — descrição (máx 26ch pra manter ritmo)
- Para destacar um marco (cor burgundy), adicione a classe modificadora `timeline__item--featured`
- Para adicionar/remover marcos: o grid desktop é `repeat(4, 1fr)` — se mudar a quantidade, ajuste no CSS `.timeline` em `components.css`

### Atualizar foto e bio do designer
- **Foto**: substituir `assets/img/designer-deivid.jpg` (proporção 4:5 recomendada)
- **Texto**: no `a-nuvvo.html`, dentro de `<div class="designer-split__body">` — 2 parágrafos com tags `<em>` (palavras-chave em burgundy) e `<strong>` (palavras-chave em ink)
- **Assinatura**: `.designer-split__signature` no fim do bloco

---

## Customizando a página "Contato"

### Atualizar endereço do Studio
No `contato.html`, atualize **3 lugares** quando o endereço mudar:

1. **Bloco visível** (Seção 3 — Studio):
   ```html
   <address style="font-style: normal;">
     Rua Teresa Lívia Rodigheri, 662<br>
     Loteamento Villa Bella<br>
     CEP 99150-000 — Marau, RS
   </address>
   ```
2. **Botão "Copiar endereço"** — atualize o `data-copy-address`:
   ```html
   <button data-copy-address="Rua Teresa Lívia Rodigheri, 662, ...">
   ```
3. **Schema.org LocalBusiness** no `<head>` — campo `address` (e `geo` se mudar de cidade).

### Trocar o link do "Como chegar" (Google Maps)
Atualize o `href` do botão "Como chegar" — geralmente um `https://maps.app.goo.gl/...`. Idealmente atualizar também o `data-map-src` do `.map-block` (URL de embed do Google Maps).

### Trocar imagens do Studio (galeria placeholder)
Hoje a galeria tem 3 SVG placeholders em `.studio-gallery__item`. Quando fotos do Studio chegarem:
1. Substitua cada `<svg>` por `<img src="assets/img/studio-N.jpg" alt="..." loading="lazy">`.
2. Mantenha a proporção: o **primeiro item** ocupa `grid-row: span 2` (vertical alto), os outros 2 são quadrados.
3. Aspect-ratio total do bloco: 4:3 desktop, 1:1 mobile.

### Configurar horário de atendimento (quando confirmado)
A seção foi omitida nesta iteração. Quando o cliente confirmar o horário, adicione um bloco depois do bloco de endereço:
```html
<div class="address-block">
  <h3 class="footer__col-title">Horário de atendimento</h3>
  <p>Segunda a Sexta · 8h–18h<br>Sábado · 8h–12h</p>
</div>
```

Pra adicionar o indicador "Aberto agora" (badge dinâmico), peça a feature — exige JS com timezone-aware logic.

### Ativar/desativar o mapa interativo (LGPD)
O mapa só carrega após clique no placeholder — comportamento LGPD-friendly que evita cookies do Google no load. Para **desativar** o mapa por completo:
- Remova ou comente todo o bloco `<div class="studio-section__map-wrapper">...</div>` no `contato.html`.

Para mudar a URL embed do mapa, ajuste o atributo `data-map-src` do `.map-block`.

---

## Customizando a página "Inspire-se"

### Como funcionam os filtros e o lightbox
A galeria é client-side. Cada imagem é um `<button class="gallery-item" data-category="X">` dentro do `<div data-gallery>`. O filtro mostra/esconde via classe `.is-filtered`. O lightbox usa o conjunto **filtrado** pra navegação prev/next — então as setas só navegam dentro da categoria ativa.

Suporte a **deep link** via query string: `inspire-se.html?categoria=living` abre direto naquele filtro.

### Adicionar uma nova foto
Inserir um novo `<button>` em qualquer lugar dentro de `<div data-gallery>`:

```html
<button type="button"
        class="gallery-item"
        data-category="living"
        aria-label="Ambiente Living — descrição curta">
  <img src="assets/img/SUA-FOTO.jpg" alt="Descrição rica da foto" loading="lazy">
  <span class="gallery-item__zoom" aria-hidden="true">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
      <path d="M11 17a6 6 0 1 0 0-12 6 6 0 0 0 0 12zM21 21l-5.4-5.4M11 8v6M8 11h6"/>
    </svg>
  </span>
</button>
```

- `data-category` aceita uma **categoria** ou **várias separadas por vírgula** (ex: `"living,detalhes"` aparece em ambos os filtros)
- `aria-label` no botão + `alt` na imagem são **obrigatórios** pra acessibilidade

### Marcar foto como destaque editorial
Adicionar uma das classes modificadoras:
- `gallery-item--wide` → ocupa 2 colunas (panorâmica)
- `gallery-item--tall` → ocupa 2 linhas (vertical alto)

Exemplo: `<button class="gallery-item gallery-item--wide" ...>`

Sugestão de ritmo: 1 destaque a cada 4-6 fotos pra não pesar.

### Versão grande no lightbox (opcional)
Se quiser servir uma versão maior pro lightbox (ex: 1800px) e thumbnail menor pro grid:

```html
<img src="assets/img/foto-thumb.jpg"
     data-full="assets/img/foto-large.jpg"
     alt="...">
```

O JS usa `data-full` se presente, senão usa o próprio `src`.

### Adicionar uma nova categoria
1. Adicionar um chip no `<div data-filter-chips>`:
   ```html
   <button type="button" class="filter-chip" data-filter="cozinha" aria-pressed="false">Cozinha</button>
   ```
2. Marcar fotos novas com `data-category="cozinha"`.
3. Pronto — o filtro funciona automaticamente.

> **Importante:** o `data-filter` deve usar **slug sem acentos** (ex: `area-social`, `detalhes`, `suites`). O texto visível do botão pode ser acentuado normalmente.

### Mudar quantas fotos carregam por vez
No `scripts/inspire-se.js`, linha próxima ao topo:
```js
const BATCH = 12;
```
Trocar pra outro número (8, 16, 24 etc).

---

## Customizando o Blog "Nuvvo News"

### Como funciona
- **Listagem** (`blog.html`): chips de filtro client-side + grid com 1º post em destaque double-width + carregar mais
- **Posts individuais** em `/blog/{slug}.html`: cada post é 1 arquivo HTML estático, com share bar sticky desktop, breadcrumb e posts relacionados manuais
- **Categorias** disponíveis (slugs no `data-filter` e `data-category`):
  - `cuidados-materiais` → "Cuidados e Materiais"
  - `dicas-decoracao` → "Dicas de Decoração"
  - `tendencias` → "Tendências"

### Como criar um novo post
1. **Duplicar** um dos arquivos esqueleto em `/blog/` (recomendo `guia-de-tecidos-para-estofados-de-alta-decoracao.html`).
2. Renomear para `{slug-novo}.html`.
3. Atualizar (procurar e substituir no arquivo):
   - `<title>` e `<meta name="description">`
   - **Open Graph** (`og:title`, `og:description`, `og:url`, `og:image`, `article:published_time`, `article:section`)
   - `<link rel="canonical">`
   - **Schema.org Article** (todo o JSON-LD `@type: Article`) — headline, description, image, datePublished, articleSection, timeRequired
   - **Schema.org BreadcrumbList** (último item com o nome curto do post)
   - Breadcrumb visível: o `<li class="breadcrumb-bar__intermediate">` da categoria + `breadcrumb-bar__current` no fim
   - `<span class="post-header__category">` com nome da categoria
   - `<h1 class="post-header__title">` com título do post
   - `<time datetime="...">` data ISO + label visível
   - `<span data-reading-time>` (preenchido automaticamente se vazio — JS calcula 200 wpm)
   - `<img>` da imagem destacada (com alt rico)
4. **Conteúdo** dentro de `.post-body`: escrever em HTML usando `<h2>`, `<h3>`, `<p>`, `<strong>`, `<em>`, `<blockquote>`, `<ul>`, `<ol>`, `<figure><img><figcaption>`, `<a>`. Tudo já tem estilo editorial pronto.
5. **CTA inline**: atualizar o texto do WhatsApp se quiser personalizar.
6. **Posts relacionados**: editar os 3 cards em `.related-posts__grid` apontando pra outros posts relevantes.
7. **Adicionar o post na listagem** (`blog.html`): inserir um novo `<a class="post-card" data-category="...">` no `.blog-grid__rest`.

### Categorias e taxonomia
- Slugs sem acento e com hífen — exemplos no header da listagem.
- Pra adicionar uma nova categoria:
  1. Adicionar chip no `<div data-filter-chips>`: `<button class="filter-chip" data-filter="novo-slug" aria-pressed="false">Nome</button>`
  2. Adicionar bloco no `<div data-category-banner>`: `<div data-banner-cat="novo-slug" hidden><h2>Nome</h2><p>Descrição.</p></div>`
  3. Marcar posts com `data-category="novo-slug"`

### Imagens recomendadas
- **Imagem destacada do post**: 1600×1067px (3:2), JPEG/WebP, < 300KB. Usada também no Open Graph.
- **Card de post (listagem)**: mesma imagem destacada, mas será cropada pra 3:2 via `object-fit: cover` (não precisa upload separado).
- **Imagens inline no corpo**: largura natural máx 720px (mesmo container do body). Usar `<figure>` + `<figcaption>` para legendas.

### Bloco de destaque (callout) dentro do post
```html
<div class="callout">
  <p>Texto em destaque com borda burgundy à esquerda e fundo cream-warm.</p>
</div>
```

### SEO de cada post — checklist
- [ ] `<title>` único, < 60 chars, formato `{Título} | Nuvvo News`
- [ ] `<meta description>` único, 140-160 chars
- [ ] `<link rel="canonical">` com URL absoluta
- [ ] Open Graph completo (title, description, url, image, type=article)
- [ ] `article:published_time` e `article:section` corretos
- [ ] Schema.org Article com `headline`, `image`, `datePublished`, `author`, `publisher`
- [ ] Schema.org BreadcrumbList
- [ ] 1 H1 apenas (no `.post-header__title`)
- [ ] H2/H3 em ordem lógica no corpo
- [ ] Alt rico na imagem destacada

### Tempo de leitura automático
Se você deixar o elemento `<span data-reading-time></span>` vazio, o JS calcula automaticamente (200 palavras/min). Se preencher manualmente (ex: "5 min de leitura"), o valor manual prevalece.

### Decisões conscientes
- **Sem comentários** — fora do escopo, evita carga de moderação.
- **Sem newsletter** — esperando integração com ferramenta de email marketing (RD Station, Mailchimp, etc.). Quando chegar, criar componente novo.
- **Sem feed RSS** — pode ser adicionado depois (estático ou gerado por backend).

---

## ⚠️ Política de Privacidade — checklist obrigatório antes de publicar

A página `politica-de-privacidade.html` é uma **MINUTA** baseada em práticas comuns da LGPD. **NÃO publique em produção sem completar este checklist:**

### Revisão jurídica
- [ ] Submeter o conteúdo completo ao **jurídico** e/ou **DPO** da Sofa News
- [ ] Receber aprovação por escrito antes da publicação
- [ ] Remover o banner "MINUTA — sujeito a revisão" no topo (`<div class="draft-notice">`)
- [ ] Remover o comentário HTML de aviso no início do arquivo

### Preenchimento dos campos `[A DEFINIR]`
Procurar no arquivo por `class="tbd"` e substituir:
- [ ] **Seção 7 (Direitos)** — e-mail oficial para exercer direitos LGPD
- [ ] **Seção 9 (DPO)** — Nome completo do Encarregado de Dados
- [ ] **Seção 9 (DPO)** — E-mail oficial do Encarregado
- [ ] **Seção 11 (Contato)** — e-mail oficial de privacidade

### Data de atualização
- [ ] Atualizar `<p class="policy-hero__updated">` com a data real de publicação
- [ ] Atualizar `"dateModified"` no Schema.org WebPage do `<head>`

### Lista de ferramentas reais usadas (Seção 5.1 — Cookies)
- [ ] Confirmar quais ferramentas de cookies estão de fato instaladas
- [ ] Atualizar o texto de cada categoria conforme realidade:
  - Essenciais: cookies de sessão do servidor, banner de consentimento
  - Funcionais: (vazio até instalar)
  - Analíticos: (Google Analytics 4 se instalado)
  - Marketing: (vazio até instalar Meta Pixel, Google Ads, etc.)

---

## Banner de Cookies (componente global LGPD)

O banner de cookies aparece em **todas as 11 páginas** (5 raiz + 5 posts + política). Carregado via `<script src="scripts/cookie-banner.js" defer>`.

### Como funciona
- **Primeira visita**: banner desliza pelo bottom após 400ms com 3 botões (Personalizar, Apenas essenciais, Aceitar todos)
- **Decisão é salva** em `localStorage` com TTL de 12 meses
- **Próximas visitas**: banner não aparece (até expirar ou usuário limpar localStorage)
- **Modal de preferências**: ao clicar em "Personalizar", abre dialog com 4 toggles (Essenciais — desabilitado, Funcionais, Analíticos, Marketing)
- **Re-abrir preferências**: qualquer elemento com `data-reopen-cookies` (já tem 1 botão na página de política, em `#gerenciar-cookies`)

### Como integrar com Google Analytics 4 (Consent Mode v2)

Em qualquer página (ou em `main.js`), antes do GA4 carregar:

```js
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}

// Default — tudo recusado até consentimento explícito
gtag('consent', 'default', {
  ad_storage: 'denied',
  analytics_storage: 'denied',
  ad_user_data: 'denied',
  ad_personalization: 'denied',
  wait_for_update: 500
});

// Sincroniza com a decisão do banner Nuvvo
window.addEventListener('nuvvo:cookie-consent', (e) => {
  const p = e.detail || {};
  gtag('consent', 'update', {
    ad_storage:          p.marketing ? 'granted' : 'denied',
    analytics_storage:   p.analytics ? 'granted' : 'denied',
    ad_user_data:        p.marketing ? 'granted' : 'denied',
    ad_personalization:  p.marketing ? 'granted' : 'denied',
  });
});
```

### API JavaScript exposta

```js
// Re-abrir modal de preferências programaticamente
window.NuvvoCookies.openPreferences();

// Forçar reset (mostra banner de novo)
window.NuvvoCookies.reset();

// Ler decisão atual
const prefs = window.NuvvoCookies.getConsent();
// → { functional: bool, analytics: bool, marketing: bool } ou null
```

### Resetar o banner pra testar
No DevTools console: `window.NuvvoCookies.reset()`.

---

## Customizando o Catálogo

### Estrutura
- **Hub** (`catalogo.html`): porta de entrada com 4 cards de categoria, carrossel de diferenciais, prévia de inspirações e suporte ao arquiteto.
- **4 listagens** (`catalogo/sofas.html`, `poltronas.html`, `bancos.html`, `camas.html`): grid de produtos por categoria com filtro de subcategoria, busca e load-more.

### Adicionar um novo produto
Em qualquer listagem (ex: `catalogo/sofas.html`), inserir um novo `<a class="card-prod">` no `<div class="catalog-grid">`:

```html
<a href="catalogo/produto-pecan.html" class="card-prod"
   data-subcategory="living"
   data-name="sofá pecan">
  <div class="product-card-btn-wrap">
    <span class="card-prod__tag">Nuvvo Signature</span> <!-- opcional -->
    <img src="../assets/img/SUA-FOTO.jpg" alt="Sofá Pecan" loading="lazy">
    <span class="product-card__overlay-btn">
      Ver detalhes
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
    </span>
  </div>
  <h2 class="card-prod__title">Sofá Pecan</h2>
  <p class="card-prod__designer">Designer Deivid de Almeida</p>
</a>
```

**Atributos obrigatórios:**
- `data-subcategory` — slug da subcategoria (ex: `living`, `retrateis`, `bancos`, `pufes`) ou `todos` se a categoria não tem subcategoria
- `data-name` — nome do produto em lowercase (usado na busca)

### Adicionar uma nova subcategoria
Em uma listagem com chips (ex: Sofás ou Bancos), adicionar novo chip no `<div data-subcat-chips>`:

```html
<button type="button" class="filter-chip" data-filter="novo-slug" aria-pressed="false">Nome Visível</button>
```

E marcar produtos com `data-subcategory="novo-slug"`.

### Tag "Signature" / "Novo"
Adicionar `<span class="card-prod__tag">Nuvvo Signature</span>` dentro do `.product-card-btn-wrap`, antes do `<img>`. Estilo já pronto.

### Recomendação de fotos
- **Proporção**: 4:5 vertical recomendado (o card recorta automaticamente via `object-fit: cover`)
- **Tamanho**: mínimo 800×1000px, máximo 1600×2000px
- **Formato**: JPEG/WebP otimizado, <300KB
- **Fundo**: pode ser ambiente ou neutro recortado — o cliente decide o padrão

### Card de categoria no Hub
O hub (`catalogo.html`) tem 4 cards (Sofás, Poltronas, Bancos, Camas). Cada um usa o componente `.card-cat` da Home com aspect ratio 3:4. Para trocar a imagem, substituir o `<img src="assets/img/cat-XXX.jpg">` ou o SVG placeholder.

### Bloco institucional intermediário
Aparece entre produtos a cada listagem. Para reposicionar ou remover, editar o `<aside class="intermediate-block">` no HTML da listagem. Pra omitir em alguma categoria, basta deletar o bloco.

### Empty state
Se filtro/busca retorna zero, mostra `<div class="empty-state">` com botões "Limpar filtros" + "Falar com especialista". Texto editável no HTML.

### Mudar batch do load-more
Em `scripts/catalogo-listagem.js`, constante `BATCH = 9`. Trocar pra outro número.

### Deep link de subcategoria via URL
`catalogo/sofas.html?subcategoria=retrateis&q=lombada` filtra direto e atualiza URL ao mudar.

### Reordenar produtos
A ordem é definida pela ordem dos elementos `<a class="card-prod">` no HTML — sem JS extra. Arrastar/soltar requer integração com backend (WordPress).

### PDP de referência: Sofá Pecan
Foi criada uma PDP completa do Pecan em `catalogo/produto-pecan.html` como template-referência. Os outros produtos ainda apontam para `#` — substituir por `produto-{slug}.html` quando criar.

---

## Customizando a PDP (Página de Detalhe do Produto)

Use `catalogo/produto-pecan.html` como template. Cada nova PDP precisa duplicar o arquivo e ajustar os campos abaixo.

### 10 blocos da PDP
1. Breadcrumb (Home > Catálogo > Categoria > Produto)
2. **Hero split** — galeria (2 fotos) à esquerda + info sticky à direita (categoria + H1 + designer + lede + CTA WhatsApp + chips)
3. **Storytelling** — bloco editorial centralizado com origem do nome (no Pecan: Noz Pecan)
4. **Galeria editorial** — grid assimétrico de 5+ fotos, abre lightbox
5. **Designer assinatura** — split 50/50 com foto P&B + bio + nome (ou variante "Nuvvo Signature")
6. **Detalhes técnicos** — imagem com 6 **hotspots clicáveis** + modal
7. **Dimensões** — desenho SVG animado + seletor de módulos dinâmico
8. **Downloads** — 2 cards (Ficha PDF + Bloco 3D)
9. **CTA Personalização** — fundo taupe
10. **Produtos relacionados** — 3 cards

### Como configurar os 6 hotspots de detalhes técnicos
Cada `<button class="tech-hotspot">` tem:
- `style="top: 50%; left: 50%;"` — **posição em % sobre a imagem** (origem: centro do ponto)
- `data-num="1"` — número exibido
- `data-title="Assento Fixo"` — título do modal
- `data-body="Descrição técnica completa..."` — corpo do modal
- `aria-label="..."` — descrição pra leitores de tela
- `<span class="tech-hotspot__tooltip">` — tooltip que aparece no hover

Pra ajustar a posição: abrir a página em DevTools → inspecionar a imagem → calcular `top%` e `left%` baseados no ponto desejado.

### Como configurar os módulos (dimensões)
No `scripts/pdp.js`, ajustar o objeto `modules`:
```js
const modules = {
  '190': { width: 190, cushions: 6 },
  '210': { width: 210, cushions: 7 },
  '230': { width: 230, cushions: 8 },
  '250': { width: 250, cushions: 9 },
};
```

E os chips no HTML (`.dim-modules-chips`):
```html
<button class="dim-module-chip" data-module-chip="190" aria-pressed="true">190 cm</button>
```

### Cadastrar o download de ficha técnica
1. Adicionar o PDF em `assets/docs/ficha-{produto}.pdf`
2. Atualizar o `<a href="...">` do `.download-card` com path correto + atributo `download`
3. Atualizar o sub-label com tamanho real do arquivo

### Cadastrar o bloco 3D (SketchUp)
1. Adicionar o `.skp` em `assets/3d/produto-{slug}.skp` (criar a pasta se necessário)
2. Atualizar o segundo `.download-card`, remover `aria-disabled="true"` e setar `href`

### Variante "Nuvvo Signature" (produto sem designer pessoa)
Substituir o bloco `.designer-sig__media` por:
```html
<div class="designer-sig__media designer-sig__media--signature">
  <img src="../assets/img/Nuvvo_simbolo.png" alt="Símbolo Nuvvo Design">
</div>
```

E o texto no `.designer-sig__content`:
```html
<h2 class="designer-sig__title">Linha autoral Nuvvo</h2>
<p class="designer-sig__body">Peça desenvolvida internamente pela curadoria Nuvvo Design...</p>
<span class="designer-sig__name">Nuvvo Signature</span>
```

Decisão lógica no admin (WordPress): se o campo "Designer" estiver preenchido → mostra a versão com foto; se vazio → mostra a versão Signature.

### Sticky mobile bar
Aparece automaticamente após o hero sumir da viewport (via IntersectionObserver). Ajustar o nome do produto no `<div class="pdp-mobile-bar__name">`.

### Decisões conscientes
- **Sem preço/checkout** — todo contato é via WhatsApp (decisão do escopo).
- **Sem variantes/cores selecionáveis** — personalização é narrativa, não catálogo. O consultor faz a curadoria.
- **WhatsApp flutuante escondido no mobile da PDP** — a bottom bar cumpre essa função melhor.
- **Lightbox com prev/next** cobre hero (2 imagens) + galeria (5 imagens) = 7 itens navegáveis em sequência.

### Acessibilidade
- Banner: `role="dialog"`, `aria-labelledby`, `aria-describedby`
- Modal: `role="dialog"`, `aria-modal="true"`, focus trap (Tab cicla), ESC fecha
- Toggles: `<input type="checkbox">` real com `aria-label`, navegáveis por teclado
- Toggle "Essenciais" tem `disabled` + texto explicativo

### Trocar imagens placeholder por reais
Procurar no `inspire-se.html` por `EM BREVE` ou pelo `<svg>` placeholder e substituir por `<img src="assets/img/SUA-FOTO.jpg" alt="..." loading="lazy">`. Manter o `<span class="gallery-item__zoom">` pra preservar o hover.

---

### Adicionar mais redes sociais (LinkedIn, YouTube, TikTok)
Na Seção 4 do `contato.html`, dentro do `<nav class="social-big">`, descomente o bloco de exemplos e ajuste os ícones. Cada link segue o padrão:
```html
<a href="..." class="social-big__link" target="_blank" rel="noopener noreferrer" aria-label="...">
  <svg viewBox="0 0 24 24" ...>...</svg>
</a>
```

---

## Pendências / placeholders a substituir

### ✅ Resolvidos nesta iteração (assets reais do cliente)
- [x] **Logo cream PNG** no header e Schema.org (`assets/img/logo-cream.png`)
- [x] **Favicon real** (`assets/img/favicon.png` — Nuvvo_simbolo)
- [x] **Fotos hero** (3 lifestyle: Pecan ambiente + 2 ressohfotoetudio)
- [x] **Fotos das categorias** (Sofás e Bancos — Poltronas/Camas removidas do menu até fotos chegarem)
- [x] **Foto do único produto real** (Sofá Pecan — produto com ficha técnica oficial)
- [x] **6 fotos de ambientação** na galeria (close-ups + lifestyle Pecan + cachorrinho)
- [x] **Slots de "próximos lançamentos"** (Coleção 02-05 com SVG placeholders editoriais — aguardando produtos reais)
- [x] **Removidas referências de inspiração** (fotos/nomes de produtos da pesquisa de referência foram substituídos por placeholders Nuvvo)

### ⚠️ Críticos pendentes (antes de ir ao ar)
- [ ] **Logo escuro (ink)** — atualmente o header scrolled usa fallback textual em Cormorant. Pedir versão escura ao cliente ou vetorizar.
- [ ] **Fotos e nomes reais dos próximos sofás** (Coleção 02-05) — atualmente em SVG placeholder editorial.
- [ ] **Ficha técnica e bloco 3D** dos próximos sofás, conforme cada um for definido pelo cliente.
- [ ] **Fotos de Poltronas** — categoria com 4 placeholders SVG até material chegar.
- [ ] **Fotos de Camas** — idem.
- [ ] **Fotos do blog** (3 imagens editoriais 16:11) — ainda em SVG placeholder.
- [ ] **Depoimentos reais** (texto + nome + cargo + foto) — ainda entre `[colchetes]`.
- [ ] **OG image dedicada** (1200×630) — temporariamente apontando pra `hero-1.png` (3MB, pesado pra OG).
- [ ] **Fonte Bloom** (.woff2) — fallback Cormorant Garamond em uso.
- [ ] **Fonte Arquitecta** (.woff2) — fallback DM Sans em uso.
- [ ] **Vídeo do hero** — `SOFA+CAPA.mp4` existe na pasta `Geral/` mas não foi integrado; decidido carrossel de fotos por enquanto.

### Polimento futuro
- [ ] Converter PNGs grandes (`hero-1.png`, `cat-sofas.png`, `gallery-1/3/6.png`) pra **JPEG/WebP** — ImageMagick não disponível no ambiente atual; usar TinyPNG/Squoosh ou Photoshop.
- [ ] Adicionar `<picture>` com WebP + JPEG fallback.
- [ ] Páginas internas (Catálogo, A Nuvvo, Inspire-se, Blog, Contato, PDPs).
- [ ] Animação custom no logo no load inicial.
- [ ] Lighthouse pass — meta: LCP < 2.5s, CLS < 0.1, A11y ≥ 95.
- [ ] Página "Designer" usando o retrato do Deivid de Almeida (`fotos nuvvo/designer_deivid_almeida.png` — já reservado).

---

## Como substituir o hero (vídeo)

No `index.html`, dentro de `<section class="hero">`, trocar todo o bloco `<div class="hero__media">...</div>` por:

```html
<div class="hero__media">
  <video autoplay muted loop playsinline poster="assets/img/hero-poster.jpg" aria-hidden="true">
    <source src="assets/video/hero.webm" type="video/webm">
    <source src="assets/video/hero.mp4" type="video/mp4">
  </video>
</div>
```

E remover o trecho de carrossel hero no `scripts/carousels.js` (bloco `// HERO carrossel`).

---

## Acessibilidade

- WCAG 2.1 AA mirado em contraste, foco visível, hierarquia, navegação por teclado, ARIA labels.
- Skip link no topo (`.skip-link`).
- Foco visível custom com `outline burgundy` 2px (passa em AA).
- `prefers-reduced-motion` honrado em todo o motion.

---

## Performance

- Fontes com `display=swap`.
- Imagens placeholder são SVG inline (zero requests adicionais).
- Lenis e Swiper carregados via CDN com `defer`.
- Nenhum JS bloqueante.
- Schema.org JSON-LD para Organization no `<head>`.

Quando fotos reais entrarem, usar `<picture>` com WebP + JPEG fallback, `loading="lazy"` em tudo abaixo da dobra, `srcset`/`sizes` apropriados.

---

## Browsers suportados

Chrome/Edge 100+, Firefox 100+, Safari 15.4+ (uso de `aspect-ratio`, `clamp()`, `:has()` opcional, `backdrop-filter`).

---

## Próximas etapas sugeridas

1. Validar a página com o cliente (estética, copy, fluxo de CTAs).
2. Substituir placeholders críticos (logo, fontes pagas, vídeo, fotos reais).
3. Auditoria Lighthouse + ajustes de performance.
4. Construir páginas internas (Catálogo, PDP, A Nuvvo, Contato).
5. Conectar Blog (provavelmente WordPress headless ou Markdown + SSG, a definir).
