<script setup>
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import { reactive } from 'vue';


const props = defineProps({
  'withdrawl': Array,
});


function getStatusText(status) {
  if (status === 0) {
    return 'Pending';
  } else if (status === 1) {
    return 'Approved';
  } else if (status === 2) {
    return 'Rejected';
  } else {
    return 'Unknown Status';
  }
}


const handleDownload = (id) => {
  axios.get(`/reject/loan/reason/${id}`, { responseType: 'blob' })
    .then((response) => {
      const blob = new Blob([response.data], { type: response.headers['content-type'] });
      const link = document.createElement('a');
      link.href = window.URL.createObjectURL(blob);
      link.download = 'loanRejected.xlsx';
      link.click();
    })
    .catch((error) => {
      console.error('Error downloading file:', error);
    });
};

const formatDate = (timestamp) => {
  const date = new Date(timestamp);
  const formattedDate = date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
  return formattedDate;
};

const getIdColumnIndex = () => {
  return 0;
};

const idColumnIndex = getIdColumnIndex();

const options = reactive({
  order: [[idColumnIndex, 'desc']],
});



</script>
<template>
    <div>
    <h1>Withdrawal List</h1>
     <DataTable style=" width: 100%; margin-top:100px;" class="display ">
         <thead>
        <tr>
            <th class="d-none">ID</th>
            <td>Withdrawl Amount</td>
            <td>Status</td>
            <td>Date</td>
            <td>Result</td>
        </tr>
         </thead>
          <tbody>
        <tr v-for="withdrawl in withdrawl" :key="withdrawl.id" :options="options">
            <td  class="d-none">{{ withdrawl.id }}</td>

            <td>{{ withdrawl.withdrawAmount}}</td>

             <td>
                {{
                    withdrawl.status == 0 ? 'Pending' :
                    withdrawl.status == 1 ? 'Approved' :
                    withdrawl.status == 2 ? 'Rejected' :
                    withdrawl.status == 3 ? 'Rejected' :
                    withdrawl.status == 4 ? 'FullComplete':
                    withdrawl.status == 'pending' ? 'Pending' :
                    withdrawl.status == 100
                }}
            </td>
            <td>{{ formatDate(withdrawl.created_at) }}</td>
            <td>
           <div>
                <template v-if="withdrawl.status == 1">
                    <a :href="'/storage/' + withdrawl.receipt" :data-lightbox="'/storage/'+withdrawl.receipt">
                        <img :src="'/storage/' + withdrawl.receipt" alt="Approved"  style="height: 100px; width: 100px;">
                    </a>
                </template>
                <template v-else-if="withdrawl.status == 2">
                    <i @click="handleDownload(withdrawl.id)" class="fa fa-download text-primary" aria-hidden="true" style="font-size: 30px;"></i>
                </template>
                <template v-else>
                  Pending
                </template>
            </div>
            </td>
        </tr>
         </tbody>
     </DataTable>
  </div>
</template>
<style scoped>
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

/* Style the table header cells */
th {
    background-color: #f2f2f2;
}

/* Style the table cells */
td {
    padding: 8px;
    text-align: left;
    border: 1px solid #ddd;
}

/* Apply some styling to the overall container */
div {
    max-width: 800px;
    margin: 0 auto;
}

/* Style the h1 heading */
h1 {
    color: #333;
}

/* Apply some spacing between table rows */
tr {
    margin-bottom: 10px;
}

/* Apply some spacing between the table cells */
td {
    padding: 10px;
}
</style>
