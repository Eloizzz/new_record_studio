<?php
/**
 * Plugin Name: New Record
 * Description: Un plugin pour ajouter soi-même un groupe selon la mise en forme convenue
 * Version: 1.0
 * Author: Eloizz
 */

if (!defined('ABSPATH')) {
    exit;
}

// Créer la table à l'activation du plugin
function new_record_install() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'new_record';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nom_groupe varchar(50) NOT NULL,
        description varchar(500),
        photo_id varchar(50),
        avis_groupe varchar(500),
        result_lien varchar(50)
        ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'new_record_install');

// Supprimer la table à la désactivation du plugin
function new_record_uninstall() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'new_record';
    $sql = "DROP TABLE if EXISTS $table_name;";
    $wpdb->query($sql);
}
register_deactivation_hook(__FILE__, 'new_record_uninstall');

// Ajouter un menu dans l'admin
function new_record_menu(){
    add_menu_page(
        'Gestion des Groupes',
        'Groupes',
        'manage_options',
        'new_record',
        'new_record_page',
        'dashicons-album',
        2
    );
}
add_action('admin_menu', 'new_record_menu');

// Afficher la page de contenu côté utilisateur
function new_record_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'new_record';

    // Traiter les requêtes Post
    if (isset($_POST['insert']) || isset($_POST['update'])) {
        $nom_groupe = sanitize_text_field($_POST['nom_groupe']);
        $description = sanitize_text_field($_POST['description']);
        $photo_id = sanitize_text_field($_POST['photo_id']);
        $avis_groupe = sanitize_text_field($_POST['avis_groupe']);
        $result_lien = sanitize_text_field($_POST['result_lien']);

        // Gérer le téléchargement de la photo
        if (!function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }
        $uploadedfile = $_FILES['photo'];
        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

        if ($movefile && !isset($movefile['error'])) {
            $photo_id = $movefile['url'];
        } else {
            $photo_id = '';
        }

        if (isset($_POST['insert'])) {
            $wpdb->insert($table_name, [
                'nom_groupe' => $nom_groupe,
                'description' => $description,
                'photo_id' => $photo_id,
                'avis_groupe' => $avis_groupe,
                'result_lien' => $result_lien,
            ]);
        } elseif (isset($_POST['update'])) {
            $wpdb->update($table_name, [
                'nom_groupe' => $nom_groupe,
                'description' => $description,
                'photo_id' => $photo_id,
                'avis_groupe' => $avis_groupe,
                'result_lien' => $result_lien,
            ], ['id' => intval($_POST['id'])]);
        }
    } elseif (isset($_POST['delete'])) {
        $wpdb->delete($table_name, ['id' => intval($_POST['id'])]);
    }

    // Récupérer les données et construire notre tableau et formulaire
    $groupes = $wpdb->get_results("SELECT id, nom_groupe, description, photo_id, avis_groupe, result_lien FROM $table_name");

    // Récupérer les données du groupe à modifier
    $edit_id = isset($_POST['edit']) ? intval($_POST['id']) : 0;
    $edit_groupe = $edit_id ? $wpdb->get_row($wpdb->prepare("SELECT id, nom_groupe, description, photo_id, avis_groupe, result_lien FROM $table_name WHERE id = %d", $edit_id)) : null;
    ?>
    <div class="wrap">
        <h1>Gestion des Groupes</h1>
        <table class="nrs-list-table widefat fixed striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom du Groupe</th>
                <th>Description</th>
                <th>Photo</th>
                <th>Avis du groupe</th>
                <th>Résultat</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($groupes as $groupe): ?>
                <tr>
                    <td><?= esc_html($groupe->id) ?></td>
                    <td><?= esc_html($groupe->nom_groupe) ?></td>
                    <td><?= esc_html($groupe->description) ?></td>
                    <td><img src="<?= esc_html($groupe->photo_id) ?>" style="max-width: 100px; max-height: 100px;" alt=""/></td>
                    <td><?= esc_html($groupe->avis_groupe) ?></td>
                    <td><?= esc_html($groupe->result_lien) ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?= esc_attr($groupe->id) ?>"/>
                            <input type="submit" name="delete" value="Supprimer" class="button button-danger"/>
                            <input type="submit" name="edit" value="Modifier" class="button button-primary"/>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <h2><?php echo $edit_id ? 'Modifier' : 'Ajouter'; ?> un nouveau Groupe</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $edit_id; ?>"/>
            <input type="text" name="nom_groupe" value="<?php echo $edit_groupe ? esc_attr($edit_groupe->nom_groupe) : ''; ?>" placeholder="Nom du Groupe" required/>
            <input type="text" name="description" value="<?php echo $edit_groupe ? esc_attr($edit_groupe->description) : ''; ?>" placeholder="Description"/>
            <input type="file" name="photo" accept="image/*"/>
            <img id="photo_preview" src="<?php echo $edit_groupe ? esc_attr($edit_groupe->photo_id) : ''; ?>" style="max-width: 100px; max-height: 100px;"/>
            <input type="text" name="avis_groupe" value="<?php echo $edit_groupe ? esc_attr($edit_groupe->avis_groupe) : ''; ?>" placeholder="Avis du groupe"/>
            <input type="text" name="result_lien" value="<?php echo $edit_groupe ? esc_attr($edit_groupe->result_lien) : ''; ?>" placeholder="Lien du résultat"/>
            <input type="submit" name="<?php echo $edit_id ? 'update' : 'insert'; ?>" value="<?php echo $edit_id ? 'Mettre à Jour' : 'Ajouter'; ?>" class="button button-primary"/>
        </form>
    </div>
    <script>
        document.querySelector('input[type="file"]').addEventListener('change', function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('photo_preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>
<?php
}

// Créer le shortcode pour afficher les informations sur la page concernée
    function new_record_shortcode($atts) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'new_record';

        // Récupérer infos
        $groupes = $wpdb->get_row($wpdb->prepare(
            "SELECT id, nom_groupe, description, photo_id, avis_groupe, result_lien FROM $table_name WHERE nom_groupe = %s",
            $atts['nom_groupe']
        ));
        if ($groupes) {
            return '<div>' .
                '<h2>' . esc_html($groupes->nom_groupe) . '</h2>' .
                '<p>' . esc_html($groupes->description) . '</p>' .
                '<p>Photo ID: ' . esc_html($groupes->photo_id) . '</p>' .
                '<p>Avis du groupe: ' . esc_html($groupes->avis_groupe) . '</p>' .
                '<p>Lien du résultat: ' . esc_html($groupes->result_lien) . '</p>' .
                '</div>';
        } else {
            return '<p>Aucun groupe trouvé.</p>';
        }
    }
    add_shortcode('new_record', 'new_record_shortcode');