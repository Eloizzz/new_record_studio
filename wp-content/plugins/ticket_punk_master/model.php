<?php

/**
 * Modèle pour gérer les événements punk
 */
class TicketPunkMasterModel
{
    private $wpdb;
    private $table_name;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $wpdb->prefix . 'ticket_punk_master';
    }

    public function create_table()
    {
        $charset_collate = $this->wpdb->get_charset_collate();
        $sql = "CREATE TABLE $this->table_name (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
            nom_evenement varchar(150) NOT NULL,
            detail_evenement varchar(150) NOT NULL,
            date_evenement datetime NOT NULL,
            nb_places_total int NOT NULL,
            nb_places_disponible int NOT NULL,
            prix decimal(10,2) NOT NULL
            ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public function drop_table()
    {
        $sql = "DROP TABLE IF EXISTS $this->table_name;";
        $this->wpdb->query($sql);
    }

    public function get_events()
    {
        return $this->wpdb->get_results("SELECT id, nom_evenement, detail_evenement, date_evenement, nb_places_total, nb_places_disponible, prix FROM $this->table_name");
    }

    public function get_event_by_name($name)
    {
        return $this->wpdb->get_row($this->wpdb->prepare(
            "SELECT id, nom_evenement, detail_evenement, date_evenement, nb_places_total, nb_places_disponible, prix FROM $this->table_name WHERE nom_evenement = %s",
            $name
        ));
    }

    public function get_event_by_id($id)
    {
        return $this->wpdb->get_row($this->wpdb->prepare(
            "SELECT id, nom_evenement, detail_evenement, date_evenement, nb_places_total, nb_places_disponible, prix FROM $this->table_name WHERE id = %d",
            $id
        ));
    }

    public function insert_event($data)
    {
        $this->wpdb->insert($this->table_name, $data);
    }

    public function update_event($data, $id)
    {
        $this->wpdb->update($this->table_name, $data, ['id' => $id]);
    }

    public function delete_event($id)
    {
        $this->wpdb->delete($this->table_name, ['id' => $id]);
    }
}