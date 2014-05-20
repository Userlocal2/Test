<section>
    <h1 class="title"><?=$info?></h1>
    <div class="">
        <form method="POST" action="/administrator/updateAltImages" enctype="multipart/form-data">
            <p>Выберите файл с описанием (обязательный формат - *.csv, разделители запятые, имя файла на латинице)</p>
            <p>Прежде чем загружать файл для обновления описания картинок, необходимо: сохранить файл в Excel в вормате CSV (разделители - запятые)</p>
            <input type="file" name="file_update_alt" size="50" value="">
            <br><br>
            <input type="submit" name="submit_file" value="Загрузить">
        </form>
        <?php if(!empty($_GET['result_update'])): ?>
            <br><br>
            <h3><?= $_GET['result_update']; ?></h3>
        <?php endif;?>
    </div>
</section><!--CENTER-->