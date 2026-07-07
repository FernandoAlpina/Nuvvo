<?php

/**
 * Classe que trabalha com Usuários no WordPress.
 */
class Alp_Usuario
{
  /**
   * Esse método cria uma role fake de usuário com o nome de 'Admin'.
   */
  public static function criar_fake_admin()
  {
    $role_id = 'admin';
    $role_display_name = 'Administrador';

    if (get_role($role_id)) return;

    $admin_role = get_role('administrator');
    $new_role = add_role($role_id, $role_display_name, $admin_role->capabilities);

    $custom_capabilities = [
      'activate_plugins',
      'cfdb7_access',
      'create_posts',
      'create_users',
      'delete_manage_options',
      'delete_others_pages',
      'delete_others_posts',
      'delete_pages',
      'delete_plugins',
      'delete_posts',
      'delete_private_pages',
      'delete_private_posts',
      'delete_published_pages',
      'delete_published_posts',
      'delete_themes',
      'delete_users',
      'edit_dashboard',
      'edit_manage_options',
      'edit_others_manage_options',
      'edit_others_pages',
      'edit_others_posts',
      'edit_pages',
      'edit_plugins',
      'edit_posts',
      'edit_private_pages',
      'edit_private_posts',
      'edit_published_pages',
      'edit_published_posts',
      'edit_theme_options',
      'edit_users',
      'export',
      'import',
      'install_languages',
      'install_plugins',
      'install_themes',
      'list_users',
      'manage_categories',
      'manage_links',
      'manage_options',
      'manage_security',
      'moderate_comments',
      'promote_users',
      'publish_manage_options',
      'publish_pages',
      'publish_posts',
      'read',
      'read_private_manage_options',
      'read_private_pages',
      'read_private_posts',
      'remove_users',
      'unfiltered_html',
      'unfiltered_upload',
      'update_core',
      'update_plugins',
      'update_themes',
      'upload_files',
      'view_site_health_checks',
      'wpseo_bulk_edit',
      'wpseo_edit_advanced_metadata',
      'wpseo_manage_options'
    ];

    foreach ($custom_capabilities as $capability) {
      $new_role->add_cap($capability);
    }
  }
}

/**
 * Hook
 */
add_action("init", ["Alp_Usuario", "criar_fake_admin"]);
