@php
    $myXmlData = "<?xml version='1.0' encoding='utf-8'?>
    <request>
        <pg_salt>0bd68e</pg_salt>
        <pg_order_id>654</pg_order_id>
        <pg_payment_id>765432</pg_payment_id>
        <pg_amount>100.0000</pg_amount>
        <pg_currency>KZT</pg_currency>
        <pg_net_amount>100.00</pg_net_amount>
        <pg_ps_amount>105.00</pg_ps_amount>
        <pg_ps_full_amount>105.00</pg_ps_full_amount>
        <pg_ps_currency>KZT</pg_ps_currency>
        <pg_payment_system>TEST</pg_payment_system>
        <pg_result>1</pg_result>
        <pg_payment_date>2008-12-30 23:59:30</pg_payment_date>
        <pg_can_reject>1</pg_can_reject>
        <pg_card_brand>CA</pg_card_brand>
        <pg_card_pan>527594******4984</pg_card_pan>
        <pg_auth_code>014318</pg_auth_code>
        <pg_captured>0</pg_captured>
        <pg_user_phone>79818244116</pg_user_phone>
        <pg_sig>da61f9d237952f56bd05c602d28780b3</pg_sig>
    </request>";

$xml=simplexml_load_string($myXmlData) or die("Error: Cannot create object");
dd((int)$xml->pg_order_id);

@endphp
