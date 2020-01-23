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
        <div class="card-header"><strong>Админ панель</strong><a class="btn btn-sm btn-primary float-right" href="/admin/news/create">Добавить новость</a></div>

        <div class="card-body" style="overflow-x: auto;">

            <?php if (!empty($news)): ?>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Anonce</th>
                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($news as $item): ?>
                        <tr>
                            <td>
                                <img src="images/<?= $item['image'] ?>" alt="" class="img-fluid" width="64" height="64">
                            </td>
                            <td><?= $item['title'] ?></td>
                            <td><?= prettyTimeStampDate($item['date']) ?></td>
                            <td><?= $item['anonce'] ?></td>
                            <td>
                                <a href="/admin/delete/<?= $item['id'] ?>" onclick="return confirm('Вы точно хотите удалить?')" class="delete btn btn-danger btn-sm">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

            <?php else: ?>
                <span>Новостей пока нет.</span>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Пагинация -->
<?php if ($pagination->countPages > 1): ?>
    <div class="col-md-12 mt-3" id="comments-pagination">
        <?= $pagination ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['errors'])) unset($_SESSION['errors']); ?>
<?php if (isset($_SESSION['success'])) unset($_SESSION['success']); ?>
<?php if (isset($_SESSION['fields_data'])) unset($_SESSION['fields_data']); ?>