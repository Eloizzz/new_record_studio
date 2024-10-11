<?php
/**
 * Plugin Name: Ticket Punk Master
 * Description: Un plugin pour gérer la vente de tickets d'événements punk
 * Version: 1.0
 * Author: Eloizz
 */

if (!defined('ABSPATH')) {
    exit;
}

// Inclure les fichiers du modèle, de la vue et du contrôleur
require_once plugin_dir_path(__FILE__) . 'model.php';
require_once plugin_dir_path(__FILE__) . 'view.php';
require_once plugin_dir_path(__FILE__) . 'controller.php';

// Initialisation du contrôleur
$controller = new TicketPunkMasterController();

// Hooks WordPress
register_activation_hook(__FILE__, [$controller, 'install']);
register_deactivation_hook(__FILE__, [$controller, 'uninstall']);
add_action('admin_menu', [$controller, 'add_menu']);
add_shortcode('ticket_punk_master', [$controller, 'shortcode']);