<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 30.06.17
 * Time: 20:57
 */
?>
    <div class="main-container">
        <?php foreach($dates as $key => $today):
            $array = $today->getTotal("+");
        ?>
        <div class="shift">
            <div class="shift-header">
                <div class="shift-date"><?=$today->getDateStart()?> | 11:00 - <?=$today->getDateEnd()?> | 11:00</div>
                <div class="shift-date">Остаток в кассе: <?=separateThousands($today->getBalance())?> руб.</div>
            </div>
            <div class="cashdesk">
                <div class="cashdesk-block incomes">
                    <div class="cashdesk-header income-header">Поступления</div>
                    <div class="cashdesk-body">
                        <div class="row table-header">
                            <span class="td source">Источник</span>
                            <span class="td payment-type">Способ оплаты</span>
                            <span class="td payer">Плательщик</span>
                            <span class="td amount">Сумма</span>
                        </div>
                        <?php foreach($today->getPayments("+") as $row): ?>
                        <?php
                            $btn_modal = 'btn-modal';
                            $action = 'edit_payment';
                            if($row['name'] == 'Остаток в кассе' || !isAdmin()){
                                $btn_modal = '';
                            }
                            elseif($row['name'] == 'внесение в кассу'){
                                $action = 'edit_cashdesk_payment';
                            }

                            ?>
                        <div data-modal="modal" data-action="<?=$action?>" data-id="<?=$row['id']?>" class="<?=$btn_modal?> row">
                            <span class="td source"><?=$row['name']?></span>
                            <span class="td payment-type"><?=$row['type']?></span>
                            <span class="td payer"><?=$row['whoPay']?></span>
                            <span class="td amount"><?=separateThousands($row['amount'])?> руб.</span>
                        </div>
                        <?php endforeach; ?>
                        <?php foreach($array as $val): ?>
                        <div class="totals">
                            <div class="totals-text">Итого <?= strtolower($val['type'])?>: </div>
                            <div class="totals-sum"> <?= separateThousands($val['total'])?> руб.</div>
                        </div>
                        <?php endforeach; ?>
                        <div class="button-wrapper">
                            <?php if(isAdmin()): ?>
                            <span data-modal="modal" data-id="" data-action="add_cashdesk_payment?date=<?=date_format(date_create($today->getDateStart() . "." .date("Y")), "Y-m-d")?>" class="btn btn-big btn-green btn-modal">Внесение в кассу</span>
    <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="cashdesk-block costs visible">
                    <div class="cashdesk-header cost-header">Списания</div>
                    <div class="cashdesk-body">
                        <div class="row table-header">
                            <span class="td source">Назначение</span>
                            <span class="td payment-type">Способ оплаты</span>
                            <span class="td amount">Сумма</span>
                        </div>
                        <?php foreach($today->getPayments("-") as $row): ?>
                        <div data-id="<?=$row['id']?>" class="row">
                            <span class="td source"><?=$row['name']?></span>
                            <span class="td payment-type"><?=$row['type']?></span>
                            <span class="td amount"><?=separateThousands($row['amount'])?> руб.</span>
                        </div>
                        <?php endforeach; ?>
                         <div class="button-wrapper">
                             <?php if(isAdmin() || $key == 0): ?>
                            <span data-modal="modal" data-action="add_cashdesk_cost?date=<?=$today->getDateStart()?>" class="btn btn-modal btn-big btn-yellow">Добавить списание</span>
                            <?php endif; ?>
                         </div>
                     </div>
                </div>
            </div>
        </div>
    <? endforeach; ?>


        <div class="filter">
            <form action="#" method="get" class="form one-line-form">
                <div class="label">
                    <label for="shifts">Кол-во смен на экране:</label>
                </div>
                <div class="input-wrapper">
                    <select name="days" class=" input select">
                        <?php foreach($days_option as $option){
                                    if($days == $option){
                                        $selected = "selected";
                                    }
                                    else{
                                        $selected = "";
                                    }
                                    echo "<option {$selected}>{$option}</option>";
                                }
                        ?>
                    </select>
                </div>
                <div class="btn-wrapper">
                    <input type="submit" class="btn btn-small btn-green-no-bg" name="" value="Показать">
                </div>
            </form>
            <?php if(isAdmin()): ?>
            <a href="/<?=$refresh?>" class="btn btn-small btn-default">Обновить значения</a>
            <?php endif; ?>
        </div>
    </div>
<?php include('footer.php');
