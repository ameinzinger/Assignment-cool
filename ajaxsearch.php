<?php 
/* USING AJAX TO SEARCH THE DATABASE */
require "templates/header.php"; 
?>

<h2 id="customTitleCreate">Find Coverage Based on Cost</h2>

<div id="customBox">
    <form>
        <select name="coverage_name" id="coverage_name" onchange="showUser(this.value)">
            <option>Select a Coverage:</option>
            <option value="Auto">Auto</option>
            <option value="Property">Property</option>
            <option value="Legal Expenses">Legal Expense</option>
        </select>
    </form> <br>
    <div id="txtHint"><b>Coverages info will be listed here.</b></div>

    <script>
        function showUser(str) {
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "search.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>
</div>