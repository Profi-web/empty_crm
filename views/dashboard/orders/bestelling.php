<?php
/*Page Info*/
$page = 'Bestelling';
$type = 'single_order';
/**/

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header('Location: /bestellingen');
}
/**/


/*Classes*/
$user = new User();
$order = new Order($id);
$notification = new Notification();
$notification->updateView($id,$user->data['id']);
//
/*CSS*/
?>
<?php

/*Header*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/components/header.php';
?>
<link rel="stylesheet" href="/assets/css/dashboard.min.css">
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/header.php';
/**/
?>
<!--    HEADER-->

<div class="container-fluid justify-content-center" style="margin-top:-40px;">
    <div class="row px-3 px-md-5 justify-content-between">
        <div class="p-0 col-12 col-xl-9 pr-xl-4 mb-4">
            <div class="card shadow" id="order_info" style="min-height: 100px;">

            </div>
        </div>
        <div class="col-12 col-xl-3 pl-md-3 pr-md-3">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="card shadow "id="order_contact" style="min-height: 180px;">

                    </div>
                </div>
                <div class="col-12 p-0">
                    <div class="card shadow mt-4">
                        <div class="card-header border-0 bg-light-second rounded-top p-3">
                            <div class="row px-4 align-items-center justify-content-between">
                                <div>Opties</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <a class="btn btn-danger text-white rounded btn-sm delete_order" id="<?php echo $order->getData('id') ?>"> Verwijderen</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="bottom_notes">BasicCRM versie <?php $versions = new Versions(); echo $versions->findLatest()[0]['version']; ?>
    | <?php echo strftime("%e %B %Y", strtotime($versions->findLatest()[0]['date'])); ?>
    <a href="/change-log">Wat is er nieuw?</a></div>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/dashboard/footer.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>
<script src="/assets/js/dashboard/main.js"></script>
<script src="/assets/js/dashboard/tables/order.js"></script>
<script src="/assets/js/dashboard/tables/companies.js"></script>
<script>
    $(document).ready(function () {
        $('#order_contact').load('/controllers/tables/orders/orders_contact_single.php?id=<?php echo $order->getData('id') ?>', function () {
        });

        $('#order_info').load('/controllers/tables/orders/orders_info_single.php?id=<?php echo $order->getData('id') ?>', function () {
        });
    });
</script>