<html>
<head>
    <title>Test</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
<section class="">
    <div class="container-fluid">
        <div class="row convert-plans plan_group" style="text-align: center">
            <div class="col-md-4" id="plan_type_one">
                <div class="card">
                    <div class="card-header plan__name" style="text-align: center">
                        CRYPTO
                    </div>
                    <div class="card-body">
                        <h5 class="card-title pricing-subtitle-title">Choose from 4 plans</h5>
                        <div class="select_dropdown" style="width:100%;border:1px solid;text-align:center">
                            $300 - Crypto
                        </div>
                        <p class="card-text">
                        <ul class="list-group plan__data-support">
                            <li class="list-group-item">First item</li>
                            <li class="list-group-item">Second item</li>
                            <li class="list-group-item">Third item</li>
                        </ul>
                        </p>
                        <ul class="show-pricing-dropdown show-dropdown">
                        </ul>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
<script>
    $(document).ready(function () {
        getForecastPlans();
    });

    function getForecastPlans(x) {
        var url = "";
        // console.log(url);
        var temp_futures = $('#plan_type_one').parent().html();

        // Clear plan table
        $('.plan_group').html("");

        // TO DELETE AFTER FUTURES MARKET NODES ARE INSERTED IN DB
        // Temporary hard-coded futures table
        $('.plan_group').append(temp_futures);

        url = "/index.php?c=Ajax&a=get_forecast_plans";
        $.get(url, function (data) {
            if (data.data != undefined)
                sortByKey(data.data, 'name');
            // pair by grains(data,is_pair_by_market_types,callbackfunction)
            var planPairs = pair_by_grains(data.data, true, group_by_plans);

        });
    }

    // Replaces string ignoring character case
    String.prototype.replaceAll = function (strReplace, strWith) {
        var esc = strReplace.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
        var reg = new RegExp(esc, 'ig');
        return this.replace(reg, strWith);
    };

    // Sort array by key
    sortByKey = function (array, key) {
        return array.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    };

    // ReCreate array to pair by grains.
    // Monthly/ yearly.
    pair_by_grains = function (array, is_pair_by_market_types = false, callback) {

        if (!is_pair_by_market_types) {
            return array;
        }

        var monthlyStr = "Monthly";
        var yearlyStr = "Yearly";

        var newObjArray = [];
        for (var i = 0; i < array.length; i++) {

            let tempObj = {};

            // Get values.
            let planName = array[i].name;
            let planID = array[i].plan_id;
            let planNickName = array[i].plan_nickname;
            let planGrain = array[i].grain;
            let planPrice = array[i].price;
            let marketTypes = array[i].market_types;

            tempObj['name'] = planName;
            tempObj['id'] = planID;
            tempObj['plan_nickname'] = planNickName;
            tempObj['grain'] = planGrain;
            tempObj['price'] = planPrice;
            tempObj['market_types'] = marketTypes;

            // Create monthly year pair plan_nickname as the key.
            let str = "";
            if (planGrain === 'month') {
                str = planName.split(monthlyStr);
            } else if (planGrain === 'year') {
                str = planName.split(yearlyStr);
            }
            // trim space.
            str = str[0].trim();

            // Remove all spaces to make it as a key.
            let key = str.replace(/\s/g, '');

            key = planNickName;


            // =============== START OF LOOPING MARKET TYPES ====================
            // construct keys for market type inside the newObject.
            let newObj = {};
            // Get existing object if it has.
            let hasExistObj = false;
            let existObj = {};
            if (newObjArray.hasOwnProperty(key)) {
                existObj = newObjArray[key];
                hasExistObj = true;
            }

            //Loop over the market types and assign values.
            let market_key = ""

            // object grain.
            let market_key_value = {};
            for (var k = 0; k < marketTypes.length; k++) {
                // if(marketTypes[k].market_type_name.includes('ETF')){
                //     debugger;
                // }
                market_key = marketTypes[k].market_type_name + '_' + marketTypes[k].market_type_id;
                // if does not have an exist object add it as a new entry.
                // where the market type is the key.
                if (!hasExistObj) {
                    // construct the new object.
                    market_key_value[planGrain] = tempObj;
                    newObj[market_key] = market_key_value;

                }
                // else, if it exist and the market key exist,
                // only modify the object if it does not have this grain.
                else {
                    if (existObj.hasOwnProperty(market_key)) {
                        let existTypeObj = existObj[market_key];
                        if (!existTypeObj.hasOwnProperty(planGrain)) {
                            existTypeObj[planGrain] = tempObj;
                            //update exist object and assign to new object.
                            existObj[market_key] = existTypeObj;

                            newObj = existObj;
                        }
                    }
                }
            }
            // =============== END OF LOOPING MARKET TYPES ====================


            newObjArray[key] = newObj;

        }
        console.log(newObjArray);

        //callback functions.
        return callback(newObjArray);
        // return new object array.
        // return newObjArray;
    };

    // Group by plans.
    // TODO. Use looping shortcut. Optimize looping.
    function group_by_plans(arrayObj,params = []) {

        //loop over data entries.
        let copyObj;
        for(let plan in arrayObj){
            copyObj =  arrayObj;
            // console.log("plan |" + plan +" |new Object" ,);

            let keys = Object.keys(omit(copyObj,plan));
            for(let i=0;i<keys.length;i++){
                // If contains these value then loop over the value and check
                // value key if it exist in the current key object.
                // if not add it.
                if(keys[i].indexOf(plan) > -1){
                    let currentObj = arrayObj[plan];
                    let containsObj = arrayObj[keys[i]];

                    for(let copy in containsObj){
                        if(!currentObj.hasOwnProperty(copy)){
                            currentObj[copy] = containsObj[copy];

                            //update current object.
                            arrayObj[plan] = currentObj;
                        }
                    }

                    // console.log("contains text:"+plan +"in key:" + keys[i]);
                }
            }
        }

        //remove pair key e.g. Crypto/FX
        // since we already paired it.
        for(let x in  arrayObj) {
            if (x.indexOf('/') > -1) {
                arrayObj = omit(arrayObj, x);
            }
        }
        console.log(arrayObj);
        return arrayObj

    }

    function omit(obj, omitKey) {
        return Object.keys(obj).reduce((result, key) => {
            if(key !== omitKey) {
                result[key] = obj[key];
            }
            return result;
        }, {});
    }

</script>
</html>