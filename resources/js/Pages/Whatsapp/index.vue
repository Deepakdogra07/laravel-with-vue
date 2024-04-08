<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
// import { defineProps, onMounted, reactive } from 'vue';
import { defineProps, reactive  , onMounted} from 'vue';
import { router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastify';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const props = defineProps({
  errors: Object,
  whatsappNumber: Number,
});


const form = reactive({
  whatsapp: props.whatsappNumber,
});

function submit() {
  router.post('/whatsapp/store', form, {
    onSuccess: page => {
      toast("Whatsapp Number Added Successfully!", {
        autoClose: 2000,
        theme: 'dark',
      });
    },
  });
}

</script>
<template>
    <AuthenticatedLayout>
          <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Whatsapp Number</h2>
          </template>

          <div class="flex items-center justify-center">
            <div class="w-full px-2">
                <form>
                    <div class="row">
                        <div class="mt-4 col-md-6">
                              <label for="title">Whatsapp Number<span class="text-danger">*</span></label>
                               <input id="title" v-model="form.whatsapp" placeholder="Enter Whatsapp Number" class="block w-full mt-1 form-control" autocomplete="whatsapp"/>
                                <div v-if="errors.whatsapp" class="text-danger">{{ errors.whatsapp }}</div>
                        </div>
                        <div class="mt-4 col-md-6">
                        </div>
                         <br/>

                        <div class="mt-4 col-md-6">
                               <Link @click="submit"  class="btn btn-primary">Submit</Link>
                        </div>
                        <div></div><br>
                    </div>
                </form>
            </div>
          </div>


    </AuthenticatedLayout>
</template>
<style>

</style>
