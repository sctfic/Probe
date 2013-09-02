<div id="list-stations" class="container">
    <!-- <div class="row"> -->
    <article class="row-fluid">
        <section id="stations-list" class="span3"
                 data-spy="affix" data-offset-top="100">
            <nav class="tabbable tabs-left">
                <ul class="nav nav-tabs">
                    <li>
                        <h3 class="nav-header"><?=i18n('configuration-stations.list.header')?></h3>
                    </li>
                    <?php
                    if (!empty($stationsConf)) {
                        foreach ($stationsConf as $_name => $conf) {
                            ?>
                            <li>
                                <a href="#station-<?=$_name?>" data-toggle="tab">
                                    <?=$_name?>
                                </a>
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        <li>
                            <a href="/configuration/add-station">
                                <i class="icon icon-plus"></i>
                                <?=i18n('configuration-stations.add-new.station')?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </nav>
        </section>
        <section id="stations-form" class="tab-content span9"
                 data-spy="scroll" data-target="#stations-list"
        >
            <?php
            if (!empty($stationsConf)) {
                $i = 0;
                foreach ($stationsConf as $_name => $conf) {
                    krsort($conf); // categorize fields
                    $data['confs'] = $conf;
                    $data['form'] = $this->config->item('add-station.form.structure');
                    $data['active'] = ($i == 0 ? 'active': null);
                    $this->load->view('configuration/stations-form', $data);
                    $i++;
                }
            }
            ?>
            <!-- <a href="#" class="btn"><i class="fam-add"></i> Add New Station</a> -->
            <div>
                <a href="/configuration/add-station" class="btn btn-success">
                    <i class="icon-white icon-plus"></i>
                    <?=i18n('configuration-station.add-new.label')?>
                </a>
            </div>
        </section>
    </article>
    <!-- </div> -->
</div>
