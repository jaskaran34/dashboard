<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

       
@vite(['resources/css/app.css'])
<style> 
.design{
    margin: 10px auto;
    padding: 10px;
}

</style>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">


    <div class="container" style="margin: auto auto;">
        <div class="row design">
            

        <div class="col-5">
                <div class="card">
                    <div class="card-header">
                    <select id="change1" onchange="call_func(this.value)">
                            <option value="1">no change</option>
                            <option value="2">change</option>
                        </select>
                        

                    </div>
                    <div class="card-body>">
                    <canvas id="myChart" ></canvas>
                    </div>
                </div>
            
            </div>

            <div class="col-5">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body>">
                    <canvas id="myChart2" ></canvas>
                    </div>
                </div>
            
            </div>





        </div>
    
</div>


        
        
        @vite(['resources/js/app.js'])

        @vite(['resources/js/script1.js'])

            
        


        <script>
    window.arr = @json($arr);
   
</script>


    </body>
</html>
