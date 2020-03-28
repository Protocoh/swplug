var SWPlug = 
{
    init: function()
    {
        SWPlug.addHandlers();
        SWPlug.setCheckingPaymentInterval();  
    },
    
    addHandlers: function()
    {
        SWPlug.addMarkStellarDataHandler();
    },
    
    addMarkStellarDataHandler: function()
    {
        $("input[class$='-field']").each(function() 
        {
            $(this).click(function() 
            {
                $(this).select();
            });
        });
    },
    
    setCheckingPaymentInterval: function()
    {
        window.setInterval(SWPlug.checkPayment, 10000);
    },
    
    checkPayment: function()
    {
        var params = {
            memo: '{memo}',
            invoiceid: '{invoiceid}',
            account: '{wallet}'
        };
        
        SWPlug.sendRequest("CheckPayment", params);
    },
    
    sendRequest: function(request, params)
    {
    	jQuery.ajax({
            url: "./modules/gateways/SWPlug/App/ajax.php",
            type: 'POST',
            async: true,
            dataType: 'json',
            data: {request: request, parameters: params},
            error: function(response) {
                console.log(response);
            },
            success: function(response) {
                SWPlug.handleActionResponse(request, response, params);
            }
        });
    },
    
    handleActionResponse: function(request, response, params)
    {
    	switch(request)
    	{
           case 'CheckPayment': SWPlug.handleCheckPaymentResponse(response); break;
    	}
    },
    
    handleCheckPaymentResponse: function(response)
    {   
        if((response.result == "success"))
        {
            $("div[class*='errorMessage']").hide();
            
            if(response.transaction.id)
            {
                var returnUrl = '{returnurl}';
                location.href = returnUrl;
            }
        }
        else
        {
            $("div[class*='errorMessage']").html(response.message);
            $("div[class*='errorMessage']").show();
        }
    }
};

SWPlug.init();