<?php
/**
 * Vue pour afficher les événements punk
 */
class TicketPunkMasterView {
    public function render_admin_page($events, $edit_event) {
        error_log('Rendering admin page view');
        ?>
        <div class="wrap">
            <h1>Gestion des événements</h1>
            <table class="widefat fixed striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom de l'événement</th>
                    <th>Detail de l'événement</th>
                    <th>Date de l'événement</th>
                    <th>Nombre de places total</th>
                    <th>Nombre de places disponibles</th>
                    <th>Prix</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= esc_html($event->id) ?></td>
                        <td><?= esc_html($event->nom_evenement) ?></td>
                        <td><?= esc_html($event->detail_evenement) ?></td>
                        <td><?= esc_html($event->date_evenement) ?></td>
                        <td><?= esc_html($event->nb_places_total) ?></td>
                        <td><?= esc_html($event->nb_places_disponible) ?></td>
                        <td><?= esc_html($event->prix) ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="id" value="<?= esc_attr($event->id) ?>"/>
                                <input type="submit" name="delete" value="Supprimer" class="button button-danger"/>
                                <input type="submit" name="edit" value="Modifier" class="button button-primary"/>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <h2><?php echo $edit_event ? 'Modifier' : 'Ajouter'; ?> un nouvel événement</h2>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $edit_event ? esc_attr($edit_event->id) : ''; ?>"/>
                <input type="text" name="nom_evenement" value="<?php echo $edit_event ? esc_attr($edit_event->nom_evenement) : ''; ?>" placeholder="Nom de l'événement" required/>
                <input type="text" name="detail_evenement" value="<?php echo $edit_event ? esc_attr($edit_event->detail_evenement) : ''; ?>" placeholder="Détail"/ required>
                <input type="datetime-local" name="date_evenement" value="<?php echo $edit_event ? esc_attr($edit_event->date_evenement) : ''; ?>" placeholder="Date de l'événement"/ required>
                <input type="text" name="nb_places_total" value="<?php echo $edit_event ? esc_attr($edit_event->nb_places_total) : ''; ?>" placeholder="Nombre de places total" required/>
                <input type="text" name="nb_places_disponible" value="<?php echo $edit_event ? esc_attr($edit_event->nb_places_disponible) : ''; ?>" placeholder="Nombre de places disponibles" required/>
                <input type="text" name="prix" value="<?php echo $edit_event ? esc_attr($edit_event->prix) : ''; ?>" placeholder="Prix" required/>
                <input type="submit" name="<?php echo $edit_event ? 'update' : 'new'; ?>" value="<?php echo $edit_event ? 'Mettre à Jour' : 'Ajouter'; ?>" class="button button-primary"/>
            </form>
        </div>
        <?php
    }



    public function render_shortcode($event) {
        if ($event) {
            ob_start();
            ?>
            <div class="evenement-info" style="text-align: center">
                <h3><?php echo esc_html($event->detail_evenement); ?></h3>
                <p>Date et heure de l'événement : <?php echo esc_html($event->date_evenement); ?></p>
                <p>Nombre de places disponibles : <?php echo esc_html($event->nb_places_disponible); ?> sur <?php echo esc_html($event->nb_places_total); ?> places totales</p>
                <p>Prix des places : <?php echo esc_html($event->prix); ?></p>
                <p>Vous aussi, vous voulez réserver vos places, {
                    <a href="mailto:spoutdownasso@gmail.com?subject=Je%20veux%20réserver%20mes%20places%20pour <?php echo esc_html($event->nom_evenement); ?>"> cliquez-ici </a>}</p>
                <p>Retrouvez toutes les informations sur la page Facebook de Spout Down, {
                    <a href="<?php echo esc_url('https://www.facebook.com/profile.php?id=100086957977475'); ?>"> cliquez-ici </a>}</p>
            </div>
            <?php
            return ob_get_clean();
        } else {
            return '<p>Aucun événement trouvé</p>';
        }
    }
}
