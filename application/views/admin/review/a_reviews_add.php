<section>
    <h1 class="title"><?= $info; ?></h1>
    <form method="POST" action="/administrator/reviews">
        <table>
            <tr>
                <td>Имя:</td>
                <td>
                    <input type="text" name="client_name" style="width:300px;">
                </td>
            </tr>
        </table>
        <div style="margin-top: 20px;">
            <label>Комментарий:</label>
            <textarea id="elm1" rows="20" style="width:100%;" name="text"></textarea>
        </div>
        <input type="hidden" name="create_date" value="<?= time(); ?>">
        <input type="hidden" name="commit_value" value="1">
        <div style="margin:10px 0;text-align:right;">
            <button class="butt_" type="submit" name="add">Добавить</button>
        </div>
    </form>
</section>