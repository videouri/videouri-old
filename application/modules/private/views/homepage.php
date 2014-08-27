<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1 class="page-title">Homepage</h1>

<div>
    <?php $this->load->view('generic/flash_error'); ?>
</div>

<div>
    <h2>
        <?php print $welcome; ?>
    </h2>

    <p class="lead">
        <?php print $explanation; ?>
    </p>

    <h2>
        Features:
    </h2>

    <ul class="list-unstyled bullet_list">
        <?php foreach ($features_list as $feature):?>
        <li><?php print $feature; ?></li>
        <?php endforeach; ?>
    </ul>
</div>