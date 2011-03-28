<div class="box">
    <h2><?php echo HTML::chars($show->cinema->name).', '.HTML::chars($movie->title) ?> - Rezerwacja biletów</h2>
    <div class="box-content">
        <?php 
            echo FORM::open();
            FORM::show_errors($errors);
        ?>
        <div class="info" style="width: 90%">
            <ul style="margin-left: 10px">
                <li>Cena biletu pojedynczego to <strong>20 zł</strong>. Cena biletu grupowego to <strong>16 zł</strong> od osoby.</li>
                <li>Rezerwacja grupowy to minimum dwa zarezerwowane miejsca.</li>
                <li>Po bilet należy zgłosić się co najmniej <strong>30 minut</strong> przed seansem.</li>
                <li>W przypadku dokonania powtórnej rezerwacji, <strong>kod identyfikacyjny</strong> biletu pozostaje niezmieniony.</li>
            </ul>
        </div>
        <div style="width: 45%">
            <?php
                echo FORM::select('type', array(0 => 'Pojedyncza', 1 => 'Grupowa'), $ticket->type );
                echo FORM::submit('type-change', 'Zmień typ rezerwacji', array('style' => 'float: right'));
            ?>
        </div>
        <h3 style="font-size: 18px;">Proszę wybrać swoje miejsce.</h3>
        <p style="font-size: 14px">Rezerwacja na dzień: <strong><?php echo DATE::locale_date('l, d.m.y H:i', $show->start_date) ?></strong></p>
        <?php
//            $curr_user = ORM::factory('user')->find(Auth::instance()->get_user()->id);
//            if ($curr_user->loaded()) {
//               $ticket = $curr_user->get_ticket_by_show($show->id);
//               $places_id = $ticket->get_places_id();
//            }
        ?>
        <dl id="place-info">
            <dt>Oznaczenia:</dt>
            <dd>
               <span class="occuppied">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class="desc"> miejsce już zarezerwowane</span><br />
               <span class="actual">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class="desc"> wybrane miejsce</span><br />
               <span class="current">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class="desc"> miejsce uprzednio zarezerwowane</span><br />
            </dd>
        </dl>
        <table id="places-view" cellspacing="0">
          <thead>
                <tr>
                    <td colspan="11">Ekran</td>
                </tr>
            </thead>
            <tbody>
            <?php 
                $show_places_id = $show->get_reserved_places_id();
                $current_ticket_places_id = $ticket->get_places_id();
             
                foreach($places as $key => $row):
            ?>
            <tr>
                <th scope="row"><?php echo strtoupper($key) ?></th>
                <?php foreach($row as $place): ?>
                        <?php
                            $class = '';
                            $id = $place->id;
                            $is_for_curr_user = FALSE;
                            $is_occupied = arr::in_array($id, $show_places_id);

                            if ($is_occupied) {
                                if (($is_for_curr_user = arr::in_array($id, $current_ticket_places_id))) {
                                    $class = 'current';
                                } else {
                                    $class = 'occupied';
                                }
                            }
                        ?>
                        <td<?php echo ! empty($class) ? ' class="'.$class.'"' : ''?>>
                            <label>
                            <?php
                                if (! $is_occupied OR $is_for_curr_user) {
                                    if ($ticket->type == 1) {
                                        echo FORM::checkbox('place[]', $place->id,
                                                $is_for_curr_user);
                                    } else {
                                        echo FORM::radio('place', $place->id,
                                                $is_for_curr_user);
                                    }                                    
                                }
                            ?>
                            </label>
                        </td>
                <?php endforeach ?>
            </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        <div>
            <input type="submit" name="submit" value="Zarezerwuj"/>
        </div>
        <?php echo FORM::close() ?>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    var occupiedColor = '#f90',
        freeColor = '#333',
        property = 'background-color';
    $('#places-view > tbody td input').click(function() {
        var radio = $(this),
            td = radio.parent().parent(),
            isChecked = radio.is(':checked');
            if (! isChecked) {
                td.removeClass('actual');
                td.removeClass('current');
            } else if (! td.hasClass('current')) {
                td.addClass('actual');
            }
    });
//    $('#places-view > tbody').find('td').click(function(evt) {
//        var td = $(this),
//            input = td.find('input');
//        td.removeAttr('class');
//        if (input.length > 0) {
//            input.trigger('click');
//            if (input.attr('type') == 'radio') {
//                $('#places-view > tbody').find('td').each(function() {
//                    var currTd = $(this);
//                    if (currTd.data('selected') == true) {
//                        currTd.css(property, freeColor);
//                        currTd.data('selected', false);
//                    }
//                })
//            }
//            td.data('selected', ! td.data('selected'));
//            if (td.data('selected') == false) {
//                td.css(property, freeColor);
//            } else {
//                td.css(property, occupiedColor);
//            }
//        }
//    }).data('selected', false);
//
//    $('#places-view input').click(function(event) {
//        //event.stopPropagation();
//    });
})
</script>