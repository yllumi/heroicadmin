<?= $this->extend('template/admin') ?>

<!-- START Content Section -->
<?php $this->section('main') ?>

<!-- Alpinejs Routers -->
<div id="app" x-data="router()">
    <?= $this->include('adminRouter') ?>
</div>

<?php $this->endSection() ?>
<!-- END Content Section -->
