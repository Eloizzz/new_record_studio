<?php
/**
 * Contrôleur pour gérer les actions de l'utilisateur
 */
class TicketPunkMasterController {
    private TicketPunkMasterModel $model;
    private TicketPunkMasterView $view;

    public function __construct() {
        $this->model = new TicketPunkMasterModel();
        $this->view = new TicketPunkMasterView();
    }

    public function install() {
        $this->model->create_table();
    }

    public function uninstall() {
        $this->model->drop_table();
    }

    public function add_menu() {
        add_menu_page(
            'Billetterie',
            'Billetterie',
            'manage_options',
            'ticket_punk_master',
            [$this, 'render_admin_page'],
            'dashicons-tickets',
            2
        );
    }

    public function render_admin_page() {
        $edit_event = null;
        if (isset($_POST['new'])) {
            $event_data = [
                'nom_evenement' => isset($_POST['nom_evenement']) ? sanitize_text_field($_POST['nom_evenement']) : '',
                'detail_evenement' => isset($_POST['detail_evenement']) ? sanitize_text_field($_POST['detail_evenement']) : '',
                'date_evenement' => isset($_POST['date_evenement']) ? sanitize_text_field($_POST['date_evenement']) : '',
                'nb_places_total' => isset($_POST['nb_places_total']) ? sanitize_text_field($_POST['nb_places_total']) : '',
                'nb_places_disponible' => isset($_POST['nb_places_disponible']) ? sanitize_text_field($_POST['nb_places_disponible']) : '',
                'prix' => isset($_POST['prix']) ? sanitize_text_field($_POST['prix']) : '',
            ];
            $this->model->insert_event($event_data);
        } elseif (isset($_POST['update'])) {
            $event_data = [
                'nom_evenement' => isset($_POST['nom_evenement']) ? sanitize_text_field($_POST['nom_evenement']) : '',
                'detail_evenement' => isset($_POST['detail_evenement']) ? sanitize_text_field($_POST['detail_evenement']) : '',
                'date_evenement' => isset($_POST['date_evenement']) ? sanitize_text_field($_POST['date_evenement']) : '',
                'nb_places_total' => isset($_POST['nb_places_total']) ? sanitize_text_field($_POST['nb_places_total']) : '',
                'nb_places_disponible' => isset($_POST['nb_places_disponible']) ? sanitize_text_field($_POST['nb_places_disponible']) : '',
                'prix' => isset($_POST['prix']) ? sanitize_text_field($_POST['prix']) : '',
            ];
            $this->model->update_event($event_data, $_POST['id']);
        } elseif (isset($_POST['delete'])) {
            $this->model->delete_event($_POST['id']);
        } elseif (isset($_POST['edit'])) {
            $edit_event = $this->model->get_event_by_id($_POST['id']);
        }
        $events = $this->model->get_events();
        $this->view->render_admin_page($events, $edit_event);
    }

    public function getModel(): TicketPunkMasterModel
    {
        return $this->model;
    }

    public function setModel(TicketPunkMasterModel $model): TicketPunkMasterController
    {
        $this->model = $model;
        return $this;
    }

    public function getView(): TicketPunkMasterView
    {
        return $this->view;
    }

    public function setView(TicketPunkMasterView $view): TicketPunkMasterController
    {
        $this->view = $view;
        return $this;
    }


    public function shortcode($atts) {
        $atts = shortcode_atts(array(
            'nom' => '',
        ), $atts);

        $event = $this->model->get_event_by_name($atts['nom']);
        return $this->view->render_shortcode($event);
    }
}