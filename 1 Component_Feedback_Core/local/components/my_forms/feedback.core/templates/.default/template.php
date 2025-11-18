<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<div class="feedback-form">
    
    <?php if($arResult["SUCCESS"]): ?>
        <p style="color: green;">Ваша заявка успешно отправлена!</p>
    <?php endif; ?>

    <?php if(!empty($arResult["ERROR_MESSAGE"])): ?>
        <ul style="color: red;">
            <?php foreach($arResult["ERROR_MESSAGE"] as $msg): ?>
                <li><?=$msg?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="<?=POST_FORM_ACTION_URI?>" method="POST">
        <?=bitrix_sessid_post()?>
        
        <p>Ваше имя: <input type="text" name="user_name" value="<?=htmlspecialchars($_REQUEST['user_name'])?>"></p>
        <p>Email: <input type="email" name="user_email" required value="<?=htmlspecialchars($_REQUEST['user_email'])?>"></p>
        <p>Сообщение: <textarea name="user_message"></textarea></p>
        
        <?php if($arParams["USE_CAPTCHA"] == "Y" && $arResult["CAPTCHA_CODE"]): ?>
            <p>
                <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                <br>Введите слово: <input type="text" name="captcha_word" required>
            </p>
        <?php endif; ?>
        
        <button type="submit">Отправить</button>
    </form>
</div>