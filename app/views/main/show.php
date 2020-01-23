<div class="col-md-12">

    <!-- Вывод флеш-сообщения в случае успеха -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION['success'] ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['errors']) && !is_array($_SESSION['errors'])): ?>
        <div class="alert alert-danger" role="alert">
            <?= $_SESSION['errors'] ?>
        </div>
    <?php endif; ?>

    <div class="card" style="margin-bottom: 20px;">
        <div class="card-header"><h3><?= $item['title'] ?></h3></div>

        <div class="card-body" style="overflow-x: auto;">
            <?php if (! empty($item['image'])): ?>
                <img src="/images/<?= $item['image'] ?>" class="mr-3" alt="...">
            <?php endif; ?>
            <p><strong>Дата добавления: </strong><?= prettyTimeStampDate($item['date']) ?></p>
            <p>
                <?= $item['text'] ?>
            </p>
            <a href="/">Вернуться назад</a>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['errors'])) unset($_SESSION['errors']); ?>
<?php if (isset($_SESSION['success'])) unset($_SESSION['success']); ?>
<?php if (isset($_SESSION['fields_data'])) unset($_SESSION['fields_data']); ?>
