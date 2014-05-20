<section>
    <h1 class="title"><?= $info; ?></h1>
    <form method="POST" action="/administrator/reviews">
        <table>
            <tr>
                <td>Имя:</td>
                <td>
                    <input type="text" name="client_name" style="width:300px;" value="<?= $reviewer->name; ?>">
                </td>
            </tr>
             <tr>
                <td>Телефон:</td>
                <td>
                    <input type="text" name="phone" style="width:300px;" value="<?= $reviewer->phone; ?>">
                </td>
            </tr>
             <tr>
                <td>Email:</td>
                <td>
                    <input type="text" name="email" style="width:300px;" value="<?= $reviewer->email; ?>">
                </td>
            </tr>
        </table>
        <div style="margin-top: 20px;">
            <label>Комментарий:</label>
            <textarea id="elm1" rows="20" style="width:100%;" name="text"><?= $reviewer->comments; ?></textarea>
        </div>
        <div style="margin-top: 20px;">
            <label>Ответ на комментарий:</label>
            <textarea id="elm2" rows="20" style="width:100%;" name="answer"><?= $reviewer->answers; ?></textarea>
        </div>
        <input type="hidden" name="pub_date" value="<?= time(); ?>">
        <input type="hidden" name="id" value="<?= $reviewer->id; ?>">
        <div style="margin:10px 0;text-align:right;">
            <button class="butt_" type="submit" name="edit">Добавить</button>
        </div>
    </form>
</section>