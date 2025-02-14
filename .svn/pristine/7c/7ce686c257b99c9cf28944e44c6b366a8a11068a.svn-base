<div class="list">
    <a href="<?php echo $account_href; ?>" class="menu__link unselectable-text-element"><?php echo  $account_menu_personal_area_header; ?></a>
    <a href="<?php echo $edit_href; ?>" class="menu__link unselectable-text-element"><?php echo  $account_menu_edit_account_button_text; ?></a>

    <a href="<?php echo $address_href; ?>" class="menu__link unselectable-text-element"><?php echo  $account_menu_address_account_button_text; ?></a>
    <a href="<?php echo $newsletter_href; ?>" class="menu__link unselectable-text-element"><?php echo  $account_menu_newsletter_account_button_text; ?></a>
    <a href="<?php echo $orders_list_href; ?>" class="menu__link unselectable-text-element"><?php echo  $account_menu_orders_list_account_button_text; ?></a>
</div>

<script>
    $(document).ready(function() {
        let links = $('.menu__link');
        for (let link of links){
            if($(link).attr('href') === window.location.href){
                $(link).addClass('menu__link_selected')
            }
        }
    });
</script>