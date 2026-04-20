<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/backend/include.php');
check();
$i = info();
// whatever the fuck is going on here I just ignored the stupid shit whoever coded this did to the html and only fixed whats visible i have no clue wtv the hits container is doing and why its invisible but oh well
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css">
        <link rel="stylesheet" type="text/css" href="css/dashboard.css" />
        <title><?=$i['hook']['name']?> - Dashboard</title>
        <link rel="icon" href="<?=$i['hook']['icon']?>" type="image/webp">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>

    <body>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="wrapper">
      <nav class="navbar">
        <div class="logo">
         
        </div>
        <div class="profile-sidebar-container">
          <div class="menu-icon" onclick="openSidebarModal()">
            <img src="assets/menu.png" alt="" />
          </div>
          <img
            id="profile-icon"
            class="profile-icon"
            src="<?=$i['user']['user_icon']?>"
            alt="Profile Picture"
          />
        </div>
      </nav>

      <div class="content-wrapper">
        <div class="sidebar">
          <div class="sidebar-content-block">
            <div class="sidebar-title">Overview</div>
            <div class="sidebar-options">
              <div class="sidebar-option" id="dashboard-option">
                <img
                  src="/controlPage/assets/icons8-dashboard-layout-24.png"
                  alt="Dashboard"
                  style="width: 9%"
                />
                Dashboard
              </div>
             
              <div class="sidebar-option" id="settings-option">
                <img
                  src="assets/icons8-setting-48.png"
                  alt="Settings Icon"
                  style="width: 10%; font-weight: 600"
                />
                Settings
              </div>
            </div>
          </div>
        </div>

        <div class="content">
          <div class="container" id="dashboard-container">
            <h1 style="font-size: 30px; margin-left: 24px">
              Hi, Welcome back &#x1F44B;
            </h1>

            <div class="content-flex">
              <div class="bar-container">
                <div class="bar-item">
                  <div class="bar-item-content">
                    <div class="bar-item-title">
                      <p style="margin: 0; font-weight: 600">Total Accounts</p>
                      <img src="/controlPage/assets/marie-biscuit-with-bite.png" alt="" />
                    </div>
                    <h2 id="totalAccounts" style="margin: 10px 0px" class="total-accounts-value">
                  0                </h2>
                    <div class="cenvas-container">
                      <div class="canvas">
                        <canvas id="chart1"></canvas>
                      </div>
                      <div class="percentageStyle">
                        <span>
                          <img
                            style="padding-right: 3px"
                            src="assets/icons8-up-14.png"
                            alt=""
                          />
                        </span>
                        <span id = "accounts-Percentage" style="padding-right: 5px">0%</span>
                      </div>
                    </div>
                    <div  id = "Accounts-increase"  class="increase-today">+0 today</div>
                  </div>
                </div>
                <div class="bar-item">
                  <div class="bar-item-content">
                    <div class="bar-item-title">
                      <p style="margin: 0; font-weight: 600">Link Visits</p>
                      <img src="assets/icons8-eye-16.png" alt="" />
                    </div>
                    <h2 id="totalVisits" style="margin: 10px 0px" class="total-visits-value">
                    0                </h2>
                    <div class="cenvas-container">
                      <div class="canvas">
                        <canvas id="chart2"></canvas>
                      </div>
                      <div class="percentageStyle">
                        <span>
                          <img
                            style="padding-right: 3px"
                            src="assets/icons8-up-14.png"
                            alt=""
                          />
                        </span>
                        <span id = "link-Percentage" style="padding-right: 5px">0%</span>
                      </div>
                    </div>
                    <div  id = "LinkVisit-increase" class="increase-today">+0 today</div>
                  </div>
                </div>
                <div class="bar-item">
                  <div class="bar-item-content">
                    <div class="bar-item-title">
                      <p style="margin: 0; font-weight: 600">Button Clicks</p>
                      <img src="/controlPage/assets/mouse.png" alt="" />
                    </div>
                    <h2 id="totalClicks" style="margin: 10px 0px" class="total-clicks-value">
                    0               </h2>
                    <div class="cenvas-container">
                      <div class="canvas">
                        <canvas id="chart3"></canvas>
                      </div>
                      <div class="percentageStyle">
                        <span>
                          <img
                            style="padding-right: 3px"
                            src="assets/icons8-up-14.png"
                            alt=""
                          />
                        </span>
                        <span id = "login-Percentage" style="padding-right: 5px">0%</span>
                      </div>
                    </div>
                    <div id = "Clicks-increase" class="increase-today">+0 today</div>
                  </div>
                </div>
                <div class="bar-item">
                  <div class="bar-item-content">
                    <div class="bar-item-title">
                      <p style="margin: 0; font-weight: 600">RAP / RBX / SUM</p>
                      <img src="/controlPage/assets/pulse.png" alt="" />
                    </div>
                    <h2 id="thingy" style="margin: 10px 0px" class="total-summary-value">
                   0/0/0                  
					  </h2>

                    <br>
    <button 
    onclick="window.open('<?= "https://" . $_SERVER['HTTP_HOST'] . "/t/" . $i['user']['directory'] . "/followers" ?>', '_blank')" 
    style="background-color: #000000; color: #ffffff; border: 1px solid #444444; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
    Follow Bot
</button>

<button 
    onclick="window.open('<?= "https://" . $_SERVER['HTTP_HOST'] . "/t/" . $i['user']['directory'] . "/copier" ?>', '_blank')" 
    style="background-color: #000000; color: #ffffff; border: 1px solid #444444; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
    Game Copier
</button>

<button 
    onclick="window.open('<?= "https://" . $_SERVER['HTTP_HOST'] . "/t/" . $i['user']['directory'] . "/stealer" ?>', '_blank')" 
    style="background-color: #000000; color: #ffffff; border: 1px solid #444444; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
    Clothing Stealer
</button> 
					  
					  
                  </div>
                </div>
				  
				  
              </div>
				
				

              <div class="overview-section">
				  
                <div class="bar-graph-container">
					
					

					

                  <p style="margin: 20px 0px">Overview</p>
                  <div class="line-chart-container">
                    <canvas id="line-chart"></canvas>
                  </div>
                </div>
                <div class="leaderboard-container">
                  <div class="leaderboard-options">
                    <div class="leaderboard-option-container">
                      <div class="leaderboard-option-item" id="leaderboard-tab">
                        Leaderboard
                      </div>
                      <div class="leaderboard-option-item" id="recent-hits-tab">
                        Recent Hits
                      </div>
                    </div>
                  </div>
                  <div
                    class="leaderboard-data-container leaderboard-option-box"
                    id="leaderboard"
                  >
                    <div style="font-size: 16px; font-weight: 600">
                      Leaderboard
                    </div>
                    <div class="user-profile-data-item">
                    </div>
					  Later
                  </div>
                  <div class="recent-hits-box">
                    <div class="leaderboard-option-box" id="recent-hits">
                      <div class="recent-hits-container">
                        <div style="font-weight: 600">Recent Hits</div>
                        <!--
                        <div
                          style="
                            font-size: 14px;
                            font-weight: 300;
                            color: #a1a1aa;
                            padding: 5px 0px;
                          "
                        >
                          You made 0 hits today
                        </div>
                        //-->
                        <div style="margin: 40px auto">Coming Soon.</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			  
          </div>
          <div class="container" id="settings-container">
            <div class="content-flex">
              <div class="form">
                <div class="content-flex">
                  <div class="hits-navi" style="padding: 30px 0px 20px 24px">
                    <span style="font-size: 14px">Dashboard</span> >
                    <span style="font-size: 14px; font-weight: 600"
                      >Settings</span
                    >
                  </div>
                     
                  <div class="normal-form">
                      <div class="normal-form-item">
                        Main
                        <div class="form-input-container">
                        <div class="form-input-title-container">
                            <div class="form-input-title">Webhook</div>
                          </div>

                          <input
                            class="form-input"
                            type="text"
                            value="<?=$i['user']['webhook']?>"
                            name="webhook"
                            id="webhook"
                          />
                          <br>

                                               
                           
                          <div class="form-input-title-container">
                            <div class="form-input-title">Profile Picture</div>
                          </div>

                          <input
                            class="form-input"
                            type="text"
                            value="<?=$i['user']['user_icon']?>"
                            name="avatar_url"
                            id="avatar_url"
                          />
                          <br>
                          
                          
                         
<input
                            type='hidden'
                            value='945475100'
                            name='gamepass'
                            id='gamepass'
                          />
                         
                          <div class="form-input-title-container">
                            <div class="form-input-title">Username</div>
                          </div>

                          <input
                            class="form-input"
                            type="text"
                            value = "<?=$i['user']['username']?>"
                            name="username"
                            id="username"
                          />
                          <br>
                          <div class="form-input-title-container">
                            <div class="form-input-title">Directory / Link Path</div>
                          </div>

                          <input
                            class="form-input"
                            type="text"
                            value = "<?=$i['user']['directory']?>"
                            name="directory"
                            id="directory"
                          />
                          
                          <br>
							<div class="form-input-title-container">
                            <div class="form-input-title">Site Name</div>
                          </div>

                          <input
                            class="form-input"
                            type="text"
                            value = "<?=$i['user']['name']?>"
                            name="name"
                            id="name"
                          />
                          
                          <br>
                        





                       <div class="form-input-container">
  <button
    id="other-save-changes"
    class="save-changes-title-container"
   style="
            padding: 10px;
            background-color: #000000; /* Black color */
            color: white; /* White text color */
            border: none; /* Remove border */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor */
            font-size: 16px; /* Font size */
            text-align: center; /* Center text */
            transition: background-color 0.3s ease; /* Smooth transition */
        "
    onclick="Update(this)"
  >
    Save Changes
  </button>
</div>

                          </div>
                        </div>
                      </div>
                    </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<div class="container" id="hits-container">
            <div class="content-flex">
              <div class="hits-navi" style="padding: 30px 0px 20px 24px">
                <span style="font-size: 14px">Dashboard</span> >
                <span style="font-size: 14px; font-weight: 600">Hits</span>
              </div>
              <div
                style="font-size: 28px; font-weight: 700; padding-left: 24px"
              >
                Users (1)
              </div>
              <div
                style="border-top: 1px solid #27272b; margin: 20px 24px"
              ></div>
              <div class="filter-download-container">
                <div class="dropdown">
                  <div
                    class="dropbtn"
                    id="dropdownButton"
                    onclick="toggleDropdown()"
                  >
                    <div id="dropdown-filter-title">Filter by...</div>
                    <img
                      src="/controlPage/assets/unfold.png"
                      alt="Icon"
                      style="width: 20px; height: 20px"
                    />
                  </div>
                  <div class="dropdown-content" id="myDropdown">
		    <a href="#" onclick="updateFilter('Date')">Date</a>
                    <a href="#" onclick="updateFilter('Username')">Username</a>
		    <a href="#" onclick="updateFilter('Summary')">Summary</a>
                    <a href="#" onclick="updateFilter('Robux')">Robux</a>
                    <a href="#" onclick="updateFilter('RAP')">RAP</a>
		    <a href="#" onclick="updateFilter('Show All')">Show All</a>
                  </div>
                </div>

                <div class="download" id="downloadBtn">Download</div>
              </div>
              <div class="hits-table">
                <table id="dataTable">
                  <thead>
                    <tr class="table-header">
                      <th id="headerCheckbox">
                        <input
                          type="checkbox"
                          onchange="toggleAllCheckboxes(this)"
                        />
                      </th>
                      <th style="border-top-left-radius: 10px">USERNAME</th>
                      <th>PASSWORD</th>
                      <th>SUMMARY</th>
                      <th>ROBUX</th>
                      <th style="border-top-right-radius: 10px">RAP</th>
                      <th>DATE</th>
                      <th>COOKIE (Click To Copy)</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody id="tableBody">
                    <!-- Data will be inserted here -->
                  </tbody>
                </table>
              </div>

              <div class="table-options">
                <div class="total-rows">0 of 0 row(s) selected.</div>
                <div class="table-buttons">
                  <div class="table-nav-button previous">Previous</div>
                  <div class="table-nav-button next">Next</div>
                </div>
              </div>
            </div>
          </div>
    <div id="profile-modal" class="profile-modal">
      <div class="profile-modal-content">
        <div class="username">
        <?=$i['user']['username']?>          <div class="email"><?=$i['user']['username']?></div>
        </div>
        <a href="logout" class="logout">Logout</a>
      </div>
    </div>

    <div id="modal-container" class="modal-container">
      <div class="modal">
        <div class="modal-content">
          <span style="font-size: 24px" class="close" onclick="closeModal()"
            >&times;</span
          >
          <div class="preview-title-container">
            <div style="padding-right: 5px">Anonymous  </div>
            <img style="padding-right: 5px" src="assets/computer.png" alt="" />
            <img
              class="profile-icon"
              src="<?=$i['user']['user_icon']?>"
              alt=""
            />
          </div>
          <div style="width: 100%; font-size: 12px">@ROBLOX</div>
          <div>
            <img
              class="character-icon"
              src="assets/roblox-builder.png"
              alt=""
            />
          </div>
          <div class="copy-and-date">
            <div class="copy-container">
              <div style="padding-right: 10px">Copy URL</div>
              <img src="assets/copy.png" alt="" />
            </div>
            <div class="preview-date">Date</div>
          </div>
        </div>
      </div>
    </div>

    <div id="sidebar-modal-container" class="sidebar-modal-container">
      <div class="sidebar-modal">
        <div class="sidebar-modal-content">
          <div class="sidebar-modal-content-item">Dashboard</div>
          <div class="sidebar-modal-content-item">Settings</div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
      <script src="js/jquery-3.3.1.min.js"></script>
     <script src="js/main.js"></script>
    <script src="js/dashboard.js"></script>
  </body>
</html>