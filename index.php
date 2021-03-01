<!DOCTYPE html>
<html>
    <head>
        <title>Тестовое задание</title>  
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script>

        var count=0;
        var pages =0;
          

        function getListInfo( i){

            
            var num_page = i;            
            var searchString = $('#search_string').val();
            var method = "getListInfo";
            $.ajax({
                type: "POST",
                url: "controllers/indexController.php",
                data: {num_page:num_page, search:searchString, method:method}
            }).done(function( result )
                {
                   
                    undapeTable(result);
                });
               
        }

        function savePerson(){           
            var name =$('#name').val();
            var state = 0;
            if(document.getElementById("state-checkbox").checked){
                state = 1;
            }else{
                state = 0;
            }
            var date = $('#date').val();
            var id = $('.save-button').id;
            var id_position = $('#position').val();
            $.ajax({
                type: "POST",
                url: "save.php",
                data: {fname:name, id:id, date:date, state:state, id_position:id_position}
            }).done(function( result )
                {
                    getListInfo(1);
                    closeForm();
                });
        }
        function getRowCount(){
           
            var method = "getListCount";
            $.ajax({
                type: "POST",
                url: "controllers/indexController.php",
                data: { method:method}
            }).done(function( result )
                {
                    count = result;
                    pages = Math.ceil(count/10);  
                    
                    updateFooter();
                });
                
                
        }
        
             
        function undapeTable(date){
            let json_object = JSON.parse(date);

            var html_table = "";  
                         
            $.each(json_object.body,function(index){
                html_table+="<tr>";
                    html_table+="<td scope='row'>";
                        html_table+="<a class='editPersan' id="+json_object.body[index].id+" href='#' >"+json_object.body[index].name+"</a>";
                    html_table+="</td>";
                    html_table+="<td>";
                        html_table+=json_object.body[index].position;
                    html_table+="</td>";
                    html_table+="<td>";
                       if(json_object.body[index].state == "0"){
                        html_table+=json_object.body[index].date;
                       }
                    html_table+="</td>";
                    html_table+="<td>";
                    if(json_object.body[index].state == "0"){
                        html_table+="Работает";
                       }else{
                        html_table+="Уволен";
                       }
                    html_table+="</td>";
                    html_table+="<td>";
                        html_table+="<Button class='editPersan' id='"+json_object.body[index].id+"'>Редактировать</button>"
                    html_table+="</td>";
                    html_table+="<td>";
                        html_table+="<Button class='deletButton' id='"+json_object.body[index].id+"'>X</button>"
                    html_table+="</td>";
                html_table+="</tr>";
            });
            
            $('#table-body').html(html_table);
            $('.editPersan').click(function() {
                    var rno = this.id;
                    $.ajax({
                        type: "POST",
                        url: "set_session.php",
                        data: { id:rno}
                        
                        }).done(function(result){
                            
                        });
                           
                    $.get('edit.php', function (data) { 
                            
                            $('#loadcontent').html(data)
                            });

                            
                            
                });
                $('.deletButton').click(function() {
                    var rno = this.id;                  
                    deletPerson(rno);
                    
                });
                


        }

        function deletPerson(id){
            var method = "deletPerson";
            $.ajax({
                        type: "POST",
                        url: "controllers/indexController.php",
                        data: { id:id, method:method}
                        
                        }).done(function(result){                           
                            getListInfo(1);
                            getRowCount(); 
                        });
        }

        function closeForm(){
            $('#loadcontent').empty();
        }

        function updateFooter(){
            console.log(pages);
            if(pages>1){
                
                var html_code = "<table> <thead>";
                for(let i = 0 ; i<pages; i++){
                 html_code+="<td> <a href='#' class='tablePageButton' id='"+ (i+1) + "'>"+(i+1)+"</a></td>"; 
                }
                html_code+="</thead></table>";
                $('#scrollTable').html(html_code);
                $('.tablePageButton').click(function() {
                    getListInfo(this.id);   
                });
            }

        }

        $(document).ready(function(){           
                getListInfo(1);    
                getRowCount();         
        }); 
              
        </script>     
    </head>
    <body>
        <div>
            <input type="text" name="search_string" id="search_string">
            <button onclick="getListInfo(1)">Поиск</button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ФИО</th>
                    <th scope="col">Должность</th>
                    <th scope="col">Дата трудоустройства</th>
                    <th scope="col">Работает/Уволен</th>
                </tr>
            </thead>
            <tbody id="table-body">
           
            </tbody>
        </table>
        <div id="scrollTable"> 
        
         </div>
        <div id="loadcontent" class = "card">
        </div>
    </body>

</html>
  