<h3><?php echo app::lang('start_greeting') ?></h3>

<p><?php echo app::lang('start_txt1') ?></p>

<ul id="select_language">
    <li>
        <form action="/install/" class="data-form" method="post">
            <input type="hidden" name="lang" value="ru">
            <button type="submit"><img src="/image.php?m=core&p=language_medium&f=lang/2_lng7f263f544635e3cd184fb6fac223781c.gif" alt=""> Русский</button>
        </form>
    </li>
    <li>
        <form action="/install/" class="data-form" method="post">
            <input type="hidden" name="lang" value="ukr">
            <button type="submit"><img src="/image.php?m=core&p=language_medium&f=lang/29_lng6f47df546e1ecd5245fde4d9e28193e0.gif" alt=""> Український</button>
        </form>
    </li>
    <li>
        <form action="/install/" class="data-form" method="post">
            <input type="hidden" name="lang" value="en">
            <button type="submit"><img src="/image.php?m=core&p=language_medium&f=lang/29_lng6f47df546e1ecd5245fde4d9e28193e2.gif" alt=""> English</button>
        </form>
    </li>
    <li>
        <form action="/install/" class="data-form" method="post">
            <input type="hidden" name="lang" value="ch">
            <button type="submit"><img src="/image.php?m=core&p=language_medium&f=lang/30_lnge4db99e54afc8c880bf7a336263b3c17.gif" alt=""> 中国的</button>
        </form>
    </li>
</ul>



