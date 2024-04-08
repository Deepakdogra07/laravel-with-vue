<script setup>
   const props = defineProps(['applied_loans_count', 'applied_loans_approved_count', 'applied_loans_rejected','applied_loans_rejected_count']);
</script>

<template>

     <h2>Applied Loan Count : {{ applied_loans_count }}</h2>
     <h2>Approved Loan Count : {{applied_loans_approved_count }}</h2>
     <h2>Rejected Loan Count :{{ applied_loans_rejected_count }}</h2>
</template>
