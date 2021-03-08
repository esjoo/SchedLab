
<link rel="stylesheet" href="style/signup.css">

<form id="regForm" action="includes/signup.inc.php" method="post">
  <h1>🧬 Welcome to schedLab 🧬 </h1>
  <h2>Register below</h2>
  <!-- One "tab" for each step in the form: -->
  <div class="tab">Name:
    <p><input placeholder="First name..." oninput="this.className = ''" name="fname"></p>
    <p><input placeholder="Last name..." oninput="this.className = ''" name="lname"></p>
  </div>
  <div class="tab">Contact Info:
    <p><input placeholder="E-mail..." oninput="this.className = ''" name="email"></p>
  </div>
  <div class="tab">Login Info:
    <p><input placeholder="Username..." oninput="this.className = ''" name="username"></p>
    <p><input placeholder="Password..." oninput="this.className = ''" name="password" type="password" ></p>
  </div>
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
  </div>
  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:40px;">
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
  </div>
</form>

<script src="scripts/signup.js"></script>
