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

        <h3 class="mb-3">Лента новостей</h3>
            <!-- Если таблица с комментарими не пуста -->
            <?php if (!empty($news)): ?>
                <!-- Вывод данных каждого комментария -->
                <?php foreach ($news as $item): ?>
                <div class="card mb-3">
                    <div class="card-header"><a href="/news/show/<?= $item['id'] ?>" class=""><?= $item['title'] ?></a></div>
                    <div class="card-body">
                        <div class="media">
                            <?php if (! empty($item['image'])): ?>
                                <img src="images/<?= $item['image'] ?>" class="mr-3 mb-3" alt="..." width="64" height="64">
                            <?php endif; ?>

                            <div class="media-body">
                                <span><small><?= prettyTimeStampDate($item['date']) ?></small></span>
                                <p>
                                    <?= $item['anonce'] ?>
                                </p>

                            </div>

                        </div>
                        <a class="btn btn-primary btn-sm" href="/news/show/<?= $item['id'] ?>">Читать далее</a>
                    </div>
                </div>

                <?php endforeach; ?>
            <!-- Если комментарии в таблице отсутствуют -->
            <?php else: ?>
                <span id="no-comments">Новостей пока нет.</span>
            <?php endif; ?>

<!-- Пагинация -->
<?php if ($pagination->countPages > 1): ?>
<div class="col-md-12 mt-3" id="comments-pagination">
    <?= $pagination ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['errors'])) unset($_SESSION['errors']); ?>
<?php if (isset($_SESSION['success'])) unset($_SESSION['success']); ?>
<?php if (isset($_SESSION['fields_data'])) unset($_SESSION['fields_data']); ?>

