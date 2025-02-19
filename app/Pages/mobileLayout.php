<?= $this->extend('template/mobile') ?>

<!-- START Content Section -->
<?php $this->section('content') ?>

    <!-- Alpinejs Routers -->
    <div id="app" x-data="router()">
        <?= $this->include('mobileRouter') ?>
    </div>

<?php $this->endSection() ?>
<!-- END Content Section -->