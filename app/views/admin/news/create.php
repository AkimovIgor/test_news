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
        <div class="card-header"><h3>Добавление новости</h3></div>

        <div class="card-body" style="overflow-x: auto;">
            <form method="POST" action="/admin/store" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleFormControlInputtitle">Заголовок</label>
                    <input type="text" name="title" id="exampleFormControlInputtitle" class="form-control<?php if (isset($_SESSION['errors']['title'])): ?> is-invalid" autofocus <?php else: ?>" <?php endif; ?> placeholder="" aria-describedby="helpId">
                    <?php if (isset($_SESSION['errors']['title'])): ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?= $_SESSION['errors']['title'][0] ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInputdate">Дата</label>
                    <input type="datetime-local" name="date" id="exampleFormControlInputdate" class="form-control<?php if (isset($_SESSION['errors']['date'])): ?> is-invalid" autofocus <?php else: ?>" <?php endif; ?> placeholder="" aria-describedby="helpId">
                    <?php if (isset($_SESSION['errors']['date'])): ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?= $_SESSION['errors']['date'][0] ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInputanonce">Анонс</label>
                    <input type="text" name="anonce" id="exampleFormControlInputanonce" class="form-control<?php if (isset($_SESSION['errors']['anonce'])): ?> is-invalid" autofocus <?php else: ?>" <?php endif; ?> placeholder="" aria-describedby="helpId">
                    <?php if (isset($_SESSION['errors']['anonce'])): ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?= $_SESSION['errors']['anonce'][0] ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInputimage">Картинка</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input<?php if (isset($_SESSION['errors']['image'])): ?> is-invalid" autofocus <?php else: ?>" <?php endif; ?> name="image" id="exampleFormControlInputimage">
                        <label class="custom-file-label">Выберите изображение</label>
                    </div>
                    <?php if (isset($_SESSION['errors']['image'])): ?>
                        <span class="invalid-feedback" role="alert" style="display: block !important;">
                            <strong><?= $_SESSION['errors']['image'][0] ?></strong>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInputtext">Текст</label>
                    <textarea name="text" id="exampleFormControlInputtext" class="form-control<?php if (isset($_SESSION['errors']['text'])): ?> is-invalid" autofocus <?php else: ?>" <?php endif; ?> placeholder="" aria-describedby="helpId"></textarea>
                    <?php if (isset($_SESSION['errors']['text'])): ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?= $_SESSION['errors']['text'][0] ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['errors'])) unset($_SESSION['errors']); ?>
<?php if (isset($_SESSION['success'])) unset($_SESSION['success']); ?>
<?php if (isset($_SESSION['fields_data'])) unset($_SESSION['fields_data']); ?>
