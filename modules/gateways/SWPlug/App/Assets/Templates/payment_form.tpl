<form method="post" action="{$action}">
    <input type="hidden" name="returnurl" value="{$returnurl}" />
    <input type="hidden" name="invoiceid" value="{$invoiceid}" />
    <input type="hidden" name="description" value="{$description}" />
    <input type="hidden" name="amount" value="{$amount}" />
    <input type="hidden" name="currency" value="{$currency}" />
    <input type="submit" class="btn btn-primary" value="{$paynowlang}" />
</form>