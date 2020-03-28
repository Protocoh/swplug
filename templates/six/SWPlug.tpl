{if $error}
    <div class='alert alert-danger'>{$error}</div>
    {if $invoiceid}
        <a href='viewinvoice.php?id={$invoiceid}' class='btn btn-primary'>Back to Invoice View</a>
    {else}
        <a href='clientarea.php' class='btn btn-primary'>Back To Client Area</a>
    {/if}
{else}
    <div class="alert alert-danger errorMessage" style="display:none;"></div>
    <p class='header'>{$langs['invoice_details_header']}</p>
    <table class='table invoice-details'>
        <tr>
            <td>{$langs['invoice_id']}</td>
            <td class='data'>{$invoice->id}</td>
        </tr>
        <tr>
            <td>{$langs['invoice_date']}</td>
            <td class='data'>{$invoice->date}</td>
        </tr>
        <tr>
            <td>{$langs['invoice_paidAmount']}</td>
            <td class='data'>{$invoice->total - $invoice->countBalance()|number_format:2:".":"."} {$invoice->user->currency->suffix}</td>
        </tr>
        <tr>
            <td>{$langs['invoice_total']}</td>
            <td class='data'>{$invoice->total} {$invoice->user->currency->suffix}</td>
        </tr>
        <tr>
            <td>{$langs['invoice_paymentmethod']}</td>
            <td class='data'>{$invoice->paymentmethod}</td>
        </tr>
    </table>
            
    <p class='header'>STELLAR INSTRUCTIONS</p>
    <p class='first-line'>Thank you - your order is now pending payment.</p>

    <p>Send exactly  
        <input type='text' class='amount-field' value='{$stellarData['amount']}' readonly='readonly' />  
        XLM with the memo tag 
        <input type='text' class='memo-field' value='{$stellarData['memo']}' readonly='readonly' />
        to: 
        <input type="text" class='wallet-field' value="{$stellarData['wallet']}" readonly="readonly" /></p>

    <p class='end-line'>After you have completed payment and the transaction has cleared, you will be redirected to invoice page.</p>
    
    <link type="text/css" rel='stylesheet' href='./modules/gateways/SWPlug/App/Assets/Css/swplug.css'></script>
    {$script}
{/if}



