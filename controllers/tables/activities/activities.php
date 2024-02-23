<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
$pagination = 1;
if (isset($_GET['page'])) {
    $pagination = $_GET['page'];
}
/**/

/*Classes*/
$table = new TableActivity($pagination, 'activities', 'Taken', $_GET['user']);
$activities = new Activities('', $table->limit);

$loginValidate = new validateLogin();
$loginValidate->securityCheck();

/**/

/*Variables*/
/**/

if (isset($_GET['status']) && $_GET['status']) {
    $gefactureerdsort = '';
    $datumsort = '';

    if ($_GET['status'] === "desc" || $_GET['status'] === "asc") {
        $statussort = strtoupper($_GET['status']);
    } else {
        $statussort = '';
    }
} elseif (isset($_GET['gefactureerd']) && $_GET['gefactureerd']) {
    $statussort = '';
    $datumsort = '';

    if ($_GET['gefactureerd'] === "desc" || $_GET['gefactureerd'] === "asc") {
        $gefactureerdsort = strtoupper($_GET['gefactureerd']);
    } else {
        $gefactureerdsort = '';
    }
} elseif (isset($_GET['datum']) && $_GET['datum']) {
    $statussort = '';
    $gefactureerdsort = '';

    if ($_GET['datum'] === "desc" || $_GET['datum'] === "asc") {
        $datumsort = strtoupper($_GET['datum']);
    } else {
        $datumsort = '';
    }
} else {
    $datumsort = '';
    $gefactureerdsort = '';
    $statussort = '';
}

if (isset($_GET['user'])) {
    if ($_GET['user'] === 'all') {
        $search = $activities->findAll($table->startfrom, $table->limit, '', $statussort, $gefactureerdsort, $datumsort);

    } else {
        $search = $activities->findAll($table->startfrom, $table->limit, $_GET['user'], $statussort, $gefactureerdsort, $datumsort);
    }
} else {
    $search = $activities->findAll($table->startfrom, $table->limit, '', $statussort, $gefactureerdsort, $datumsort);
}
print_r($activities->db->last());
foreach ($search as $activity) {
    ?>
    <tr id="<?php echo $activity['id'] ?>" class="user_tablee work_table_tr">
        <td valign="middle" width="10%" class="tr_click">
            <?php echo $activity['date'] ?>
        </td>
        <td valign="middle" width="5%" class="tr_click">
            #<?php echo $activity['id'] ?>
        </td>
        <?php
        if ($_GET['user'] === 'all') {
            ?>
            <td valign="middle" width="10%" class="tr_click">
                <?php echo $activities->getUser($activity['user']) ?>
            </td>
            <?php
        }
        ?>
        <td valign="middle" width="30%" class="tr_click">
            <?php echo $activities->getExcerpt($activity['text']); ?>
        </td>
        <td valign="middle" width="20%" id="<?php echo $activity['id'] ?>">
            <span class="tr_click"> <?php echo $activities->getRelation($activity['relation_id'], $activity['relation_type']) ?></span><i
                    class="fad fa-info-circle <?php echo $activities->getRelationColor($activity['relation_id'], $activity['relation_type']); ?> ml-2 companyInfo"
                    data-type="<?php echo $activity['relation_type'] ?>"
                    data-relation="<?php echo $activity['relation_id'] ?>"></i>
            <div style="cursor:default;" class="modal fade"
                 id="relationModal<?php echo $activity['relation_id'] . $activity['relation_type']; ?>" tabindex="-1"
                 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content rounded">
                        <div class="modal-header">
                            <h5 class="modal-title"
                                id="exampleModalLabel"><?php echo $activities->getRelationData($activity['relation_id'], $activity['relation_type'], 'name') ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i
                                            class="fad fa-sign <?php echo $activities->getRelationColor($activity['relation_id'], $activity['relation_type']); ?>"></i> <?php echo $activities->getRelationData($activity['relation_id'], $activity['relation_type'], 'name') ?>
                                </li>
                                <li class="list-group-item"><i
                                            class="fad fa-phone-office <?php echo $activities->getRelationColor($activity['relation_id'], $activity['relation_type']); ?>"></i> <?php echo $activities->getRelationData($activity['relation_id'], $activity['relation_type'], 'phonenumber') ?>
                                </li>
                                <li class="list-group-item"><i
                                            class="fad fa-at <?php echo $activities->getRelationColor($activity['relation_id'], $activity['relation_type']); ?>"></i> <?php echo $activities->getRelationData($activity['relation_id'], $activity['relation_type'], 'email') ?>
                                </li>
                                <li class="list-group-item"><i
                                            class="fad fa-road <?php echo $activities->getRelationColor($activity['relation_id'], $activity['relation_type']); ?>"></i> <?php echo $activities->getRelationData($activity['relation_id'], $activity['relation_type'], 'address') ?>
                                </li>
                                <li class="list-group-item"><i
                                            class="fad fa-map <?php echo $activities->getRelationColor($activity['relation_id'], $activity['relation_type']); ?>"></i> <?php echo $activities->getRelationData($activity['relation_id'], $activity['relation_type'], 'zipcode') ?>
                                </li>
                                <li class="list-group-item"><i
                                            class="fad fa-city <?php echo $activities->getRelationColor($activity['relation_id'], $activity['relation_type']); ?>"></i> <?php echo $activities->getRelationData($activity['relation_id'], $activity['relation_type'], 'city') ?>
                                </li>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <?php
                            if ($activity['relation_type'] == 1) {
                                ?>
                                <button type="button" class="btn btn-success rounded text-white"
                                        onclick="window.location.href = '/bedrijf?id=<?php echo $activity['relation_id']; ?>'">
                                    Bekijken
                                </button>
                                <?php
                            } elseif ($activity['relation_type'] == 2) {
                                ?>
                                <button type="button" class="btn btn-success rounded text-white"
                                        onclick="window.location.href = '/contact?id=<?php echo $activity['relation_id']; ?>'">
                                    Bekijken
                                </button>
                                <?php
                            } elseif ($activity['relation_type'] == 3) {
                                ?>
                                <button type="button" class="btn btn-success rounded text-white"
                                        onclick="window.location.href = '/leverancier?id=<?php echo $activity['relation_id']; ?>'">
                                    Bekijken
                                </button>
                                <?php
                            }
                            ?>
                            <button type="button" class="btn btn-info rounded text-white" data-dismiss="modal"
                                    onclick="stopPro()">Sluiten
                            </button>


                        </div>
                    </div>
                </div>
            </div>
        </td>
        <td valign="middle" width="20%" data-uid="<?php echo $activity['id'] ?>">
            <div class="py-2 w-100" data-toggle="modal"
                 data-target="#status<?php echo $activity['id'] ?>"><?php echo $activities->getStatus($activity['status']) ?></div>
            <div style="cursor:default" class="modal fade" id="status<?php echo $activity['id'] ?>" tabindex="-1"
                 role="dialog" aria-labelledby="Modal status #<?php echo $activity['id'] ?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content rounded">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Taak #<?php echo $activity['id'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert_field_<?php echo $activity['id'] ?>">
                            </div>
                            <div class="list-group" id="statusList">
                                <div data-uid="<?php echo $activity['id'] ?>" data-status="1"
                                     class="list-group-item list-group-item-action <?php if ($activity['status'] == 1) {
                                         echo 'active';
                                     } ?>">
                                    <div class="row justify-content-between px-3">
                                        <div>Open</div>
                                        <div><i class="fad fa-clock"></i></div>
                                    </div>
                                </div>
                                <div data-uid="<?php echo $activity['id'] ?>" data-status="2"
                                     class="list-group-item list-group-item-action <?php if ($activity['status'] == 2) {
                                         echo 'active';
                                     } ?>">
                                    <div class="row justify-content-between px-3">
                                        <div>Uitgevoerd</div>
                                        <div><i class="fad fa-check-double text-green"></i></div>
                                    </div>
                                </div>
                                <div data-uid="<?php echo $activity['id'] ?>" data-status="3"
                                     class="list-group-item list-group-item-action <?php if ($activity['status'] == 3) {
                                         echo 'active';
                                     } ?>">
                                    <div class="row justify-content-between px-3">
                                        <div>In behandeling</div>
                                        <div><i class="fad fa-pause-circle text-indianred"></i></div>
                                    </div>
                                </div>
                                <div data-uid="<?php echo $activity['id'] ?>" data-status="4"
                                     class="list-group-item list-group-item-action <?php if ($activity['status'] == 4) {
                                         echo 'active';
                                     } ?>">
                                    <div class="row justify-content-between px-3">
                                        <div>Wachten op klant</div>
                                        <div><i class="fad fa-dolly text-warning"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info rounded text-white" data-dismiss="modal">Sluiten
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </td>
        <td valign="middle" width="20%" class="" data-uid="<?php echo $activity['id'] ?>">
            <div class="py-2 w-100" data-toggle="modal"
                 data-target="#facturering<?php echo $activity['id'] ?>"><?php echo $activities->getFacturering($activity['facturering']) ?></div>
            <div style="cursor:default" class="modal fade" id="facturering<?php echo $activity['id'] ?>" tabindex="-1"
                 role="dialog" aria-labelledby="Modal Factuerering #<?php echo $activity['id'] ?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content rounded">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Taak #<?php echo $activity['id'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert_field_<?php echo $activity['id'] ?>">
                            </div>
                            <div class="list-group" id="factureringList">
                                <div data-uid="<?php echo $activity['id'] ?>" data-facturering="1"
                                     class="list-group-item list-group-item-action <?php if ($activity['facturering'] == 1) {
                                         echo 'active';
                                     } ?>">
                                    <div class="row justify-content-between px-3">
                                        <div>Nee</div>
                                        <div><i class="fad fa-print"></i></div>
                                    </div>
                                </div>
                                <div data-uid="<?php echo $activity['id'] ?>" data-facturering="2"
                                     class="list-group-item list-group-item-action <?php if ($activity['facturering'] == 2) {
                                         echo 'active';
                                     } ?>">
                                    <div class="row justify-content-between px-3">
                                        <div>Ja</div>
                                        <div><i class="fad fa-print text-green"></i></div>
                                    </div>
                                </div>
                                <div data-uid="<?php echo $activity['id'] ?>" data-facturering="3"
                                     class="list-group-item list-group-item-action <?php if ($activity['facturering'] == 3) {
                                         echo 'active';
                                     } ?>">
                                    <div class="row justify-content-between px-3">
                                        <div>Service / Garantie</div>
                                        <div><i class="fad fa-shield-alt text-cyan"></i></div>
                                    </div>
                                </div>
                                <div data-uid="<?php echo $activity['id'] ?>" data-facturering="4"
                                     class="list-group-item list-group-item-action <?php if ($activity['facturering'] == 4) {
                                         echo 'active';
                                     } ?>">
                                    <div class="row justify-content-between px-3">
                                        <div>Eigen gebruik</div>
                                        <div><i class="fad fa-badge text-warning"></i></div>
                                    </div>
                                </div>
                                <div data-uid="<?php echo $activity['id'] ?>" data-facturering="5"
                                     class="list-group-item list-group-item-action <?php if ($activity['facturering'] == 5) {
                                         echo 'active';
                                     } ?>">
                                    <div class="row justify-content-between px-3">
                                        <div>Contract</div>
                                        <div><i class="fad fa-file-contract text-primary"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info rounded text-white" data-dismiss="modal">Sluiten
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </td>
        <td valign="middle" width="6%" data-uid="<?php echo $activity['id'] ?>" class="text-center">
            <i class="fad fa-info-circle" data-toggle="modal" data-target="#modal<?php echo $activity['id'] ?>"
               style="width: 100%;height: 100%"></i>
            <div style="cursor:default" class="modal fade" id="modal<?php echo $activity['id'] ?>" tabindex="-1"
                 role="dialog" aria-labelledby="Modal #<?php echo $activity['id'] ?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content rounded">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Taak #<?php echo $activity['id'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="list-group">
                                <?php
                                if ($activity['time_from'] && $activity['time_to']) {
                                    $time = $activity['time_from'] . ' tot ' . $activity['time_to'];
                                } else {
                                    $time = '-';
                                }

                                if ($activity['traveltime']) {
                                    $traveltime = $activity['traveltime'];
                                } else {
                                    $traveltime = '-';
                                }
                                ?>
                                <a class="list-group-item ">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 font-weight-bold">Tijd:</h5>
                                    </div>
                                    <p class="mb-1 text-left"><?php echo $time; ?></p>
                                </a>
                                <a class="list-group-item ">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 font-weight-bold">Reistijd:</h5>
                                    </div>
                                    <p class="mb-1 text-left"><?php echo $traveltime; ?></p>
                                </a>
                                <a class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 font-weight-bold">Informatie:</h5>
                                    </div>
                                    <p class="mb-1 text-left"><?php echo $activities->getExcerptFull($activity['text']); ?></p>
                                </a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info rounded text-white" data-dismiss="modal">Sluiten
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </td>

    </tr>
    <?php
}
$errors = array_filter($search);
if (empty($errors)) {

    ?>
    <tr class="user_tablee work_table_tr">
        <td valign="middle" width="10%" class="tr_click">
            -
        </td>
        <td valign="middle" width="10%" class="tr_click">
            -
        </td>
        <td valign="middle" width="10%" class="tr_click">
            -
        </td>
        <td valign="middle" width="10%" class="tr_click">
            -
        </td>
        <td valign="middle" width="10%" class="tr_click">
            -
        </td>
        <td valign="middle" width="10%" class="tr_click">
            -
        </td>
        <td valign="middle" width="10%" class="tr_click">
            -
        </td>
    </tr>
    <?php
}
?>

<script>
    $('.change_status').on('click', function (e) {
        var uid = $(this).data('uid');
        var id = $('.activities_table').attr('id');
        var user = $('.currentuser').attr('id');
        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/activities/activities_contact_save_status.php?id=' + uid, //Your form processing file URL
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    var url = new URL(window.location.href);
                    if (url.searchParams.get('gefactureerd')) {
                        var gefactureerd = url.searchParams.get('gefactureerd');
                        if (gefactureerd === "asc" || gefactureerd === "desc") {
                            var gefactureerdsearch = '&gefactureerd=' + gefactureerd;
                        }
                    } else {
                        var gefactureerdsearch = '';
                    }

                    if (url.searchParams.get('status')) {
                        var status = url.searchParams.get('status');
                        if (status === "asc" || status === "desc") {
                            var statussearch = '&status=' + status;
                        }
                    } else {
                        var statussearch = '';
                    }

                    if (url.searchParams.get('datum')) {
                        var datum = url.searchParams.get('datum');
                        if (datum === "asc" || datum === "desc") {
                            var datumsearch = '&datum=' + datum;
                        }
                    } else {
                        var datumsearch = '';
                    }
                    $('.activities_table').load('/controllers/tables/activities/activities.php?page=' + id + '&user=' + user + gefactureerdsearch + statussearch + datumsearch, function () {
                    });
                }
            }
        });

    });


    $('tbody .tr_click').on('click', function e() {
        if ($(this).parent().attr('id') == '' || $(this).parent().attr('id') == undefined) {
            window.location.reload();
        } else {
            window.location.href = '/taak?id=' + $(this).parent().attr('id');
        }
    });


    $('.companyInfo').click(function (event) {
        var relation = $(this).data('relation');
        var type = $(this).data('type');
        $('#relationModal' + relation + type).modal('show');
    // console.log(relation + type);
    });


    $('#factureringList .list-group-item').on('click', function () {
        var factureringsID = $(this).data('uid');
        var facturering = $(this).data('facturering');

        var id = $('.activities_table').attr('id');
        var user = $('.currentuser').attr('id');

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/activities/activities_contact_save_facturering.php?id=' + factureringsID + '&facturering=' + facturering, //Your form processing file URL
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#facturering' + factureringsID).modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();


                    var url = new URL(window.location.href);
                    if (url.searchParams.get('gefactureerd')) {
                        var gefactureerd = url.searchParams.get('gefactureerd');
                        if (gefactureerd === "asc" || gefactureerd === "desc") {
                            var gefactureerdsearch = '&gefactureerd=' + gefactureerd;
                        }
                    } else {
                        var gefactureerdsearch = '';
                    }

                    if (url.searchParams.get('status')) {
                        var status = url.searchParams.get('status');
                        if (status === "asc" || status === "desc") {
                            var statussearch = '&status=' + status;
                        }
                    } else {
                        var statussearch = '';
                    }

                    if (url.searchParams.get('datum')) {
                        var datum = url.searchParams.get('datum');
                        if (datum === "asc" || datum === "desc") {
                            var datumsearch = '&datum=' + datum;
                        }
                    } else {
                        var datumsearch = '';
                    }
                    $('.activities_table').load('/controllers/tables/activities/activities.php?page=' + id + '&user=' + user + gefactureerdsearch + statussearch + datumsearch, function () {
                    });
                } else {
                    $(".alert_field_" + factureringsID).load("/controllers/error.php", {
                        message: data.message,
                        class: data.class
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
            }
        });

    });


    $('#statusList .list-group-item').on('click', function () {
        var statusID = $(this).data('uid');
        var statusStatus = $(this).data('status');

        var id = $('.activities_table').attr('id');
        var user = $('.currentuser').attr('id');

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '/controllers/tables/activities/activities_contact_save_status.php?id=' + statusID + '&status=' + statusStatus, //Your form processing file URL
            success: function (data) {
                data = JSON.parse(data);

                if (data.status === 'success') {
                    $('#facturering' + statusID).modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();


                    var url = new URL(window.location.href);
                    if (url.searchParams.get('gefactureerd')) {
                        var gefactureerd = url.searchParams.get('gefactureerd');
                        if (gefactureerd === "asc" || gefactureerd === "desc") {
                            var gefactureerdsearch = '&gefactureerd=' + gefactureerd;
                        }
                    } else {
                        var gefactureerdsearch = '';
                    }

                    if (url.searchParams.get('status')) {
                        var status = url.searchParams.get('status');
                        if (status === "asc" || status === "desc") {
                            var statussearch = '&status=' + status;
                        }
                    } else {
                        var statussearch = '';
                    }

                    if (url.searchParams.get('datum')) {
                        var datum = url.searchParams.get('datum');
                        if (datum === "asc" || datum === "desc") {
                            var datumsearch = '&datum=' + datum;
                        }
                    } else {
                        var datumsearch = '';
                    }
                    $('.activities_table').load('/controllers/tables/activities/activities.php?page=' + id + '&user=' + user + gefactureerdsearch + statussearch + datumsearch, function () {
                    });
                } else {
                    $(".alert_field_" + statusID).load("/controllers/error.php", {
                        message: data.message,
                        class: data.class
                    }, function () {

                        $('.alert').fadeIn(1000);
                    });
                }
            }
        });

    });
</script>
<style>
    .change_facturering:hover {
        cursor: pointer;
        color: orange;
        font-weight: bold;
    }

    .change_facturering:hover > .fas {
        color: orange;
        font-weight: bold;
    }

</style>
