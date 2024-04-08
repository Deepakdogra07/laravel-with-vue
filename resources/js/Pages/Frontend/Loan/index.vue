<!-- <script setup>
import { ref, reactive } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { useToast } from 'vue-toastify';
import Swal from 'sweetalert2';



const showNotificationBubble = ref(0);

const handleNewNotification = () => {
  showNotificationBubble.value += 1;
};

const showNotification = () => {
  showNotificationBubble.value = !showNotificationBubble.value;
  if (showNotificationBubble.value) {
    notificationCount.value = 0;
  }
};

const phoneNumber = ref('987654321');


const props = defineProps({
  loanRecord: Array
});




const deleteRecord = async (id) => {
  const { value: confirmed } = await Swal.fire({
    title: 'Are you sure?',
    text: 'You want to Delete Customer Record?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
  });

  try {
    if (confirmed) {
      router.delete(`/delete/${id}`);
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Customer Deleted Successfully',
      });
      router.visit('/user/loan')
    } else {
      Swal.fire({
        icon: 'info',
        title: 'Canceled',
        text: 'Deletion canceled.',
      });
    }
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Error Deleting Customer. Please try again.',
    });
  }
};



const editRecord = (id) => {
  router.visit(`/edit/${id}`);
}

const logout = async () => {
  try {
    await axios.post('/logout/user');
    router.replace('/');
  } catch (error) {
    console.error('Logout failed', error);
  }
};

const viewRecord = (id) => {
  router.get(`/loan/view/page/${id}`);
}


const reapplyLoan = (id) => {
  router.post(`/reapply/loan/${id}`);
}

const getIdColumnIndex = () => {
  return 0;
};

const idColumnIndex = getIdColumnIndex();

const options = reactive({
  order: [[idColumnIndex, 'desc']],
});


const formatDate = (timestamp) => {
  const date = new Date(timestamp);
  const formattedDate = date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
  return formattedDate;
};


</script>

<template>
<div v-if="showNotificationBubble" class="notification-bubble">
  You have a new notification!
</div>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                                </Link>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex mt-3">
                                <Link href="/">Home</Link>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('user.dashboard')" :active="route().current('user.dashboard')">
                                     Dashboard
                                </NavLink>
                            </div>


                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('user.loan')" :active="route().current('user.loan')">
                                    Loan
                                </NavLink>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('applyloan')" :active="route().current('applyloan')">
                                    Create Loan
                                </NavLink>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('affiliate')" :active="route().current('affiliate')">
                                    Affiliate
                                </NavLink>
                            </div>

                             <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('loan.calculator')" :active="route().current('loan.calculator')">
                                    Loan Calculator
                                </NavLink>
                            </div>

                             <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('user.own.profile')" :active="route().current('user.own.profile')">
                                    My Profile
                                </NavLink>
                            </div>

                           <Link  class="mt-3 ml-4" href="/aboutus">About us</Link>

                             <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('contactus')" :active="route().current('contactus')">
                                    Contact Us
                                </NavLink>
                            </div>


                               <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('referral.management')" :active="route().current('referral.management')">
                                     Referral Management
                                </NavLink>
                            </div>



                            <div class="hidden-space sm:-my-px sm:ms-10 sm:flex mt-2">
                                <form :action="route('logout.user')" method="post" @submit.prevent="logout">
                                    <button class="logout-button" type="submit">Logout</button>
                                </form>
                            </div>

                             <i class="fas fa-bell notification-icon mt-1 ml-3" @click="showNotification">
                                <span v-if="showNotificationBubble === 0" class="notification-count">{{ showNotificationBubble }}</span>
                            </i>

                             <a :href="'https://wa.me/' + phoneNumber" target="_blank" class="whatsapp-button">
                                 <i class="fab fa-whatsapp mt-4"></i>
                                </a>


                        </div>
                    </div>
                    <div>


                        <DataTable style=" width: 100%; margin-top:100px;" class="display" :options="options">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th style="border: 1px solid #ddd;">Serial Number</th>
                                    <th style="border: 1px solid #ddd;">Application Id</th>
                                     <th style="border: 1px solid #ddd;">Amount</th>
                                    <th style="border: 1px solid #ddd;">Date</th>
                                    <th style="border: 1px solid #ddd;">Number of Months</th>
                                    <th style="border: 1px solid #ddd;">Status</th>
                                     <th style="border: 1px solid #ddd;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr v-for="(loan, index) in props.loanRecord" :key="loan.id">
                                    <td  class="d-none">{{ loan.id }}</td>
                                    <td style="border: 1px solid #ddd;">{{ props.loanRecord.length - index }}</td>
                                    <td style="border: 1px solid #ddd;">{{ loan.application_id }}</td>
                                    <td style="border: 1px solid #ddd;">{{ loan.loan_amount }}</td>
                                    <td style="border: 1px solid #ddd;">{{ formatDate(loan.created_at) }}</td>
                                    <td style="border: 1px solid #ddd;">{{ loan.numberOfmonths }} Months</td>
                                    <td style="border: 1px solid #ddd;">
                                        <span v-if="loan.status === 0">Pending</span>
                                        <span v-else-if="loan.status === 1">Approved</span>
                                        <span v-else-if="loan.status === 2">Rejected</span>
                                        <span v-else-if="loan.status === 3">Incomplete</span>
                                        <span v-else-if="loan.status === 4">FullComplete</span>
                                    </td>

                                    <td style="border: 1px solid #ddd;">
                                        <Link @click.prevent="viewRecord(loan.id)">
                                        <button class="btn btn-info btn-sm text-white">View</button>
                                        </Link> &nbsp;

                                        <InertiaLink :href="'/edit/' + loan.id" @click.prevent="editRecord(loan.id)" v-if="loan.status !== 4">
                                           <button class="btn btn-primary btn-sm"> Edit</button>
                                        </InertiaLink> &nbsp;

                                        <InertiaLink :href="'/delete/' + loan.id" method="delete" v-if="loan.status !== 4"
                                            @click.prevent="deleteRecord(loan.id)">
                                           <button class="btn btn-danger btn-sm">Delete</button>
                                        </InertiaLink>&nbsp;

                                       <Link v-if="loan.status === 2" href="/">
                                          <button class="btn btn-success btn-sm"  @click.prevent="reapplyLoan(loan.id)">Reapply</button>
                                       </Link>
                                    </td>

                                </tr>
                            </tbody>
                        </DataTable>
                </div>
                </div>
            </nav>
 </div>
    </div>
</template>
<style scoped>
.hidden-space {
    margin-right: 8px;
}

.logout-button {
    background-color: #3490dc;
    color: #ffffff;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.logout-button:hover {
    background-color: #2779bd;
}

.notification-icon {
    cursor: pointer;
    font-size: 36px;
    color: #cf17b7;
    position: relative;
}

.notification-count {
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: #cf17b7;
    color: #ffffff;
    padding: 4px 8px;
    border-radius: 50%;
    font-size: 12px;
}

.notification-bubble {
    position: absolute;
    top: 50px;
    right: 20px;
    background-color: #42cf17;
    color: #ffffff;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 999;
    animation: fadeInUp 0.5s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}


.whatsapp-button {
    display: inline-block;
    margin-left: 10px;
    cursor: pointer;
    font-size: 24px;


    color: #25d366;

    text-decoration: none;
}

.whatsapp-button i {
    margin-right: 5px;
    margin-top: 4px;
    font-size: 40px;
}
</style> -->
<script setup>
import Footer from "../../Frontend/footer.vue";
import Header from "../../Frontend/header.vue";
import "../../../../css/frontend.css";
import Sidebar from "../../Frontend/Layouts/sidebar.vue"
import { Head, Link, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import axios from 'axios';
import { onBeforeMount, ref, reactive } from 'vue';

const props = defineProps([
  'applied_loans_count',
  'applied_loans_approved_count',
  'applied_loans_rejected',
  'applied_loans_rejected_count',
  'loanRecord'
]);


const formatDate = (timestamp) => {
  const date = new Date(timestamp);
  const formattedDate = date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
  return formattedDate;
};

const viewRecord = (id) => {
  router.get(`/loan/view/page/${id}`);
}



// Afflicate
const loanUsers = ref('');
const pending = ref('');
const approved = ref('');
const rejected = ref('');
const sta = ref('');

let selectedUser = null;

onBeforeMount(async () => {
  console.log('onBeforeMount')
  try {
    await fetchData();
  } catch (error) {
    console.error('Error during component mount:', error);
  }
  console.log('onBeforeMount2')

});


const showTable = ref(0);
const fetchData = async () => {
  if (selectedUser == null) {
    const apiUrl = `/loan/value/${selectedUser}`;
    try {
      const response = await axios.get(apiUrl);
      if (response.data.status) {
        console.log(response.data.data[0].user.status, 'REsponse')
        loanUsers.value = response.data.data;
        pending.value = response.data.pending;
        approved.value = response.data.approved;
        rejected.value = response.data.rejected;
        sta.value = response.data.data[0].user.status;
      }
      showTable.value++;
      console.log('fetched');
    } catch (error) {
      console.error('Error fetching user data:', error);
    }
  }
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
  <Head title="User-Dashboard" />
  <div class="user-dashboard-header">
    <Header class="login-wrapper-dashboard" />
  </div>



  <div class="user-dashboard"> </div>
  <div class="user-dashboard-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <Sidebar />
        </div>
        <div class="col-lg-9">
          <div class="d-flex justify-between align-items-center mt-3">
            <h2>Painel</h2>
            <div class="apply-now">
              <Link class="" href="/applyloan">APLIQUE AGORA</Link>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-lg-4 col-md-6 col-12 cards-spaces">
              <div class="first-card">
                <p>TOTAL DE EMPRÉSTIMOS APLICADOS</p>
                <h2>{{ applied_loans_count }}</h2>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12 cards-spaces">
              <div class="second-card">
                <p>EMPRÉSTIMOS APROVADOS</p>
                <h2>{{ applied_loans_approved_count }}</h2>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12 cards-spaces">
              <div class="third-card">
                <p>EMPRÉSTIMOS REJEITADOS</p>
                <h2>{{ applied_loans_rejected_count }}</h2>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-md-7 ">
              <div class="myloan-tabel">
                <div class="d-flex justify-between align-items-center mt-3">
                  <h3>Meus empréstimos</h3>
                  <div class="see-all">
                    <Link class="" href="/all-loans">Ver tudo</Link>
                  </div>
                </div>


                <!-- <div class="table-responsive">
                  <table class="table ">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>View</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>John</td>
                        <td>Doe</td>
                        <td>@john</td>
                        <th><a href="">View</a></th>
                      </tr>

                      <tr>
                        <td>2</td>
                        <td>Jane</td>
                        <td>Doebjfkdlfjbf bjdfb jb bjbfjdbjfdkb dfjbdfbj;dfb
                        </td>
                        <td>@jane</td>
                        <th><a href="">View</a></th>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>Bob</td>
                        <td>Smith</td>
                        <td>@bob</td>
                        <th><a href="">View</a></th>
                      </tr>

                    </tbody>
                  </table>
                </div> -->


                <DataTable style=" width: 100%; margin-top:20px;" class="display myLoans-table" :options="options">
                  <thead>
                    <tr>
                      <th class="d-none">ID</th>
                      <th style="border: 1px solid #ddd;">#</th>
                      <th style="border: 1px solid #ddd;">Data</th>
                      <th style="border: 1px solid #ddd;">Quantia</th>
                      <th style="border: 1px solid #ddd;">Status</th>
                      <th style="border: 1px solid #ddd;"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(loan, index) in props.loanRecord" :key="loan.id">
                      <td class="d-none">{{ loan.id }}</td>
                      <td class="tabel-blue-text" style="border: 1px solid #ddd;">{{ props.loanRecord.length - index }}
                      </td>
                      <td class="tabel-blue-text" style="border: 1px solid #ddd;">{{ formatDate(loan.created_at) }}</td>
                      <td style="border: 1px solid #ddd; color: #22B909 !important ; font-weight: 600;">{{
                        loan.loan_amount }}</td>
                      <td style="border: 1px solid #ddd;">
                        <span class="pending-btn" v-if="loan.status == 0">Pendente</span>
                        <span class="Approved-btn" v-else-if="loan.status == 1">Aprovado</span>
                        <span class="Rejected-btn" v-else-if="loan.status == 2">Rejeitado</span>
                        <span class="Doc-Pending-btn" v-else-if="loan.status == 3">Incompleto</span>
                        <span class="FullComplete-btn" v-else-if="loan.status == 4">concluída</span>
                        <span class="Re-Apply-btn" v-else-if="loan.status == 5">Reaplicar</span>
                        <span class="Transfered-btn" v-else-if="loan.status == 6">Transferido</span>
                      </td>

                      <td class="tabel-blue-text" style="border: 1px solid #ddd;">
                        <Link @click.prevent="viewRecord(loan.id)" class="table-right-arrow"><i
                          class="bi bi-chevron-right"></i></Link>
                        <!-- <Link @click.prevent="viewRecord(loan.id)">
                                           <button class="btn btn-info btn-sm text-white">Visualizar</button>
                                        </Link> &nbsp; -->
                        <!-- <Link v-if="loan.status === 2" href="/">
                                          <button class="btn btn-success btn-sm"  @click.prevent="reapplyLoan(loan.id)">Reaplicar</button>
                                       </Link> -->
                      </td>
                    </tr>
                  </tbody>
                </DataTable>
              </div>
            </div>

            <div class="col-md-5 mb-3">
              <div class="myloan-tabel">
                <div class="d-flex justify-between align-items-center mt-3">
                  <h3>Minha indicação</h3>
                  <div class="see-all">
                    <Link class="" href="/affiliate">Ver tudo</Link>
                  </div>
                </div>
                <div class="table-responsive">
                  <DataTable style=" width: 100%; margin-top:20px;" :options="options" :key="showTable"
                    class="display myLoans-table">
                    <thead>
                      <tr>
                        <th scope="col" class="px-6 py-3 d-none">
                          Eu ia
                        </th>
                        <th scope="col" class="px-6 py-3" style="width: 100%;">
                          Data de inscrição
                        </th>
                        <th scope="col" class="px-6 py-3">
                          Status
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="loan in loanUsers" :key="loan.id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="d-none">{{ loan.id }}</td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                          {{ formatDate(loan.user.created_at) }}
                        </td>
                        <td class="px-6 py-4">
                          <p class="pending-btn" v-if="sta == 0">Pendente</p>
                          <p class="Approved-btn" v-else-if="sta == 1">Aprovado</p>
                          <p class="Rejected-btn" v-else-if="sta == 2">Rejeitado</p>
                          <p class="pending-btn" v-else>Em processamento</p>
                        </td>
                      </tr>
                    </tbody>
                  </DataTable>



                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Footer /></template>
