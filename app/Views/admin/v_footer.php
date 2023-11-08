<!-- start footer -->
        </div>
    </div>
    </body>
    <!-- jquery -->
    <script src="<?= base_url(); ?>/assets/jquery-3.6.1/jquery-3.6.1.min.js"></script>
    <!-- datatables -->
    <script src="<?= base_url(); ?>/assets/DataTables/datatables.min.js"></script>
    <!-- jquery confirm -->
    <script src="<?= base_url(); ?>/assets/jquery-confirm-v3.3.4/js/jquery-confirm.js"></script>
    <!-- bootstrap js -->
    <script src="<?= base_url(); ?>/assets/bootstrap-5.2.2/js/bootstrap.bundle.min.js"></script>
    <!-- base js -->
    <script src="<?= base_url(); ?>/assets/js/base.js"></script>
	<!-- Custom Loaded Js -->
	<?php foreach ($js as $row): ?>
        <script src="<?= base_url(); ?><?= $row ?>"></script>
    <?php endforeach ?>
</html>