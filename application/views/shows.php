<?php defined('SYSPATH') or die('No direct script access allowed') ?>
<div class="box">
  <?php
        $act = Request::instance()->action;
        if ($act == 'id') {
            $box_title = 'Lista aktualnych seansów';
        } else {
            $box_title = 'Lista wszystkich seansów';
        }
    ?>
    <h2><?php echo $box_title ?></h2>
    <div class="box-content">
        <?php
            if (! $shows->count()) {
                echo '<div class="info">Nie ma żadnych aktualnych seansów.</div>';
            } else {
        ?>
        <table cellspacing="0" class="items">
            <caption>Lista seansów</caption>
            <thead>
                <tr>
                    <th scope="col" class="name">Film</th>
                    <th scope="col">Kino</th>
                    <th scope="col">Czas rozpoczęcia</th>
                    <th scope="col">Czas zakończenia</th>
                    <th scope="col">Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $format = 'd.m.y H:i';
                foreach($shows as $show) :?>
                <tr>
                    <td class="name"><?php echo HTML::chars($show->movie->title) ?></td>
                    <td><?php echo HTML::chars($show->cinema->name) ?></td>
                    <td><?php echo DATE::locale_date($format, $show->start_date) ?></td>
                    <td><?php echo DATE::locale_date($format, $show->end_date) ?></td>
                    <td>
                        <?php
                            if ($is_admin) {
                                echo View::factory('admin/actions')
                                                ->set('controller', 'shows')
                                                ->set('id', $show->id);
                            } else {
                                echo HTML::anchor(Route::get('reservation')->uri(array('id' => $show->id)), 'Rezerwuj');
                            }
                        ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
       <?php } ?>
    </div>
</div>
