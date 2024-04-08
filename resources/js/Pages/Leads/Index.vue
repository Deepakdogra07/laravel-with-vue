    <script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Modal from '@/Components/Modal.vue';
    import { ref } from 'vue';

    defineProps({
        leads: {
            type: Array
        }
    });

    const options = {
        dom: 'Bftip',
        buttons: ['csv'],
        select: true
    };
    const submit = () => {
        form.post(route('leads'));
    };
    const selectedLeadId = ref(null);
    const assignAgent = ref(false);

    const assign = (leadId) => {
        selectedLeadId.value = leadId;
        // console.log(selectedLeadId.value);
        assignAgent.value = true;
    }
    const closeModal = () => {
        // console.log('vue')
        assignAgent.value = false;

    }
    </script>

    <template>
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Leads</h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                        <div class="p-12 text-gray-900">
                            <DataTable class="display" :options="options" style="border:2px black ;width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Loan Amount</th>
                                        <th>Installments</th>
                                        <th>Loan Status</th>
                                        <th>Assign Agent</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="lead in leads" :key="lead.id">
                                        <td>{{ lead.name }}</td>
                                        <td>{{ lead.loan_amount }}</td>
                                        <td>{{ lead.installments }}</td>
                                        <td>{{ lead.loan_status }}</td>
                                        <td>{{ lead.agent }}</td>
                                        <td :class="{ 'approved': lead.status == 1, 'rejected': lead.status == 0 }">
                                            {{ lead.status == 1 ? 'Approved' : 'Rejected' }}
                                        </td>
                                        <td>
                                            <button class="btn btn-info btn-sm" @click="assign(lead.id)">Assign Agent</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </DataTable>
                        </div>
                    </div>
                </div>
            </div>
    <Modal :show="assignAgent" :leadId="selectedLeadId" :modal="1" @close="closeModal" />
        </AuthenticatedLayout>
    </template>

