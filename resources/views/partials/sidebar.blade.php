<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
   <div class="menu_section">
      <h3>{{ (Auth::check() && $user->user_name ) ? $user->user_name : "" }}</h3>
      <ul class="nav side-menu">
         <!-- <li><a><i class="fa fa-home"></i> Dashboard <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
               <li><a href="/dashboard">Dashboard</a></li>
            </ul>
         </li> -->
         <!-- <li><a><i class="fa fa-edit"></i> Merchant <span class="fa fa-chevron-down"></span></a>
         
            <ul class="nav child_menu">
               <li><a href="/agent">Transaction Report</a></li>
            </ul>
            
         </li> -->
         <li><a><i class="fa fa-edit"></i> Merchant <span class="fa fa-chevron-down"></span></a>
         
            <ul class="nav child_menu">
               <li><a href="/agent">Transaction Report</a></li>
            </ul>

           

             <!-- <ul class="nav child_menu">
               <li><a href="/lugyimin.dev">LuGyiMin Transaction</a></li>
            </ul> -->
            <!-- <ul class="nav child_menu">
               <li><a href="/dashboard">Test Report</a></li>
            </ul> -->
         </li>

         <!-- <li><a><i class="fa fa-sitemap"></i> Transaction <span class="fa fa-chevron-down"></span></a>
         
            <ul class="nav child_menu">
               <li><a target="_blank" href="http://lugyimin.dev/login">LuGyiMin</a></li>
            </ul>

         </li> -->




           




      </ul>
   </div>
</div>
<!-- /sidebar menu -->
