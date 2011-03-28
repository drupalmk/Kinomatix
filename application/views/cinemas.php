<?php defined('SYSPATH') or die('No direct script access allowed') ?>
<div class="box">
    <h2>Lista naszych kin</h2>
    <div class="box-content">
        <?php
            if (! $cinemas->count()) {
                echo '<div class="info">Nie ma żadnych dostępnych kin.</div>';
            } else {
        ?>
        <table cellspacing="0" class="items">
            <caption>Lista kin</caption>
            <thead>
                <tr>
                    <th scope="col" class="name">Nazwa</th>
                    <th scope="col">Adres</th>
                    <th scope="col">Miasto</th>
                    <th scope="col">Województwo</th>
                    <th scope="col">Telefon</th>
                    <?php echo ($is_admin) ? '<th scope="col">Akcje</th>' : '' ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $format = 'l, d.m.y H:i';
                foreach($cinemas as $cinema) :?>
                <tr>
                    <td class="name"><?php echo HTML::chars($cinema->name) ?></td>
                    <td><?php echo HTML::chars($cinema->address) ?></td>
                    <td><?php echo HTML::chars($cinema->city) ?></td>
                    <td><?php echo HTML::chars($cinema->province->name) ?></td>
                    <td><?php echo HTML::chars($cinema->phone) ?></td>
                        <?php
                            if ($is_admin) {
                                echo '<td>';
                                echo View::factory('admin/actions')
                                                ->set('controller', 'cinemas')
                                                ->set('id', $cinema->id);
                                echo '</td>';
                            } else {
                                //echo HTML::anchor(Route::get('reservation')->uri(array('id' => $show->id)), 'Rezerwuj');
                            }
                        ?>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
       <?php } ?>
    </div>
</div>
