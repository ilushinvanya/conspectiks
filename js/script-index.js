    $(document).ready(function(){
        ajax('country', 1);

        $('.selecter_country, .selecter_city, .selecter_univers').selectize({
            maxItems: 1,
            valueField: 'id',
            labelField: 'title',
            searchField: 'title',
            onChange: function(e){
                var nameSelect = $(this)[0].eventNS;
//                console.warn($(this)[0]);

                if(nameSelect==".selectize1"){
//                    console.log('Выбран город: '+e);
                    var selectizeeCity = $('.selecter_city')[0].selectize;
                    var selectizeeUniver = $('.selecter_univers')[0].selectize;
                    selectizeeCity.clearOptions();
                    selectizeeUniver.clearOptions();
                    ajax('city', e);
                }else if(nameSelect==".selectize2"){
//                    console.log('Выбран университет: '+e);
                    ajax('univers', e);
                }else{
//                    console.log('Выбран другое: '+e);
                };


            }
//            create: false
        });

        selectize1 = $('.selecter_country')[0].selectize;

        selectize1.on('type', function(val){
            vk_search_city(val);
        });


    });


function vk_search_city(str){
    availableTags = [];
    $.ajax({
        type: "POST",
        url: 'https://api.vk.com/method/database.getCities?country_id=1&count=40&q='+str,
        dataType: 'jsonp',
        success: function(data)
        {
            for (i=0;i<data.response.length;i++){
                availableTags.push({title: data.response[i].title, id: data.response[i].cid});
            }
            var selectize = $('.selecter_country')[0].selectize;

            selectize.clearOptions();
            selectize.addOption(availableTags);
            selectize.open();
        }
    });
};



function ajax(who, id){
    availableTags = [];
    if (who == 'country') {
        var $url = 'https://api.vk.com/method/database.getCities?country_id='+id+'&count=40&need_all=0';
    }
    if (who == 'city') {
        var $url = 'https://api.vk.com/method/database.getUniversities?country_id=1&city_id='+id+'&count=100';
    }
    else if (who == 'univers') {
        var $url = 'https://api.vk.com/method/database.getFaculties?university_id='+id+'&count=100';
    }

    $.ajax({
        type: "POST",
        url: $url,
        dataType: 'jsonp',
        success: function(data)
        {
            if (who=='country'){
                for (i=0;i<data.response.length;i++){
                    availableTags.push({title: data.response[i].title, id: data.response[i].cid});
                }
            }else{
                for (i=1;i<data.response.length;i++){
                    availableTags.push({title: data.response[i].title, id: data.response[i].id});
                }
            }
            var selectize = $('.selecter_'+who)[0].selectize;
            selectize.clearOptions();
            selectize.addOption(availableTags);
            if (who!='country'){
                selectize.open();
            };

        }
    });
};