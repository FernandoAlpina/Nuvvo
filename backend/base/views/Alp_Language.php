<?php

class Alp_Language
{
      use Alp_Renderable;

      public function __construct()
      {
      }

      public function render(): void
      {
            $this
                  ->add_render($this->render_language())
                  ->echo_render();
      }

      protected function render_language(): string
      {
            return $this->html('frontend/base/language/block-language.php');
      }
}
