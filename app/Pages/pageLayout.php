<?= $this->extend('template/mobile') ?>

<!-- START Content Section -->
<?php $this->section('content') ?>

<!-- Alpinejs Routers -->
<div id="app" x-data="router()"></div>

<?= $this->include('pageRouter') ?>

<?php $this->endSection() ?>
<!-- END Content Section -->