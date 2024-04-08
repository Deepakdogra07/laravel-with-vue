<template>
  <div class="loan-management-container">
    <div class="jumbotron">
      <h1 class="display-4">Loan Management Instructions</h1>
      <p class="lead">
        Follow these steps to effectively manage your loan and stay on top of
        your finances.
      </p>
    </div>

    <div class="container mt-4">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h2 class="card-title">Getting Started</h2>
              <ol>
                <li>Log in to your account.</li>
                <li>Navigate to the "Loan Management" section.</li>
                <li>View your current loan details.</li>
                <li>Make payments or check your repayment schedule.</li>
              </ol>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h2 class="card-title">Important Information</h2>
              <p>
                Please ensure that you adhere to the terms and conditions of
                your loan agreement. Failure to do so may result in additional
                charges or penalties.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'LoanManagement',
};
</script>

<style scoped>
/* Import Bootstrap styles or add the CDN link in your HTML file */

.loan-management-container {
  margin-top: 50px;
}

.jumbotron {
  background-color: #007bff;
  color: #fff;
  text-align: center;
  padding: 60px;
}

.card {
  margin-bottom: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-title {
  color: #007bff;
}

/* Add more styling based on your preferences */
</style>
