<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="">
        <header class="danger-header">
            <h2>Eliminar cuenta</h2>

            <p>
                Una vez que elimines tu cuenta, todos tus recursos y datos serán eliminados permanentemente.
                Antes de continuar, descarga cualquier información que desees conservar.
            </p>
        </header>
        <div class="button-delete">
            <DangerButton @click="confirmUserDeletion">
                Eliminar cuenta
            </DangerButton>
        </div>

        <!-- ? MODAL -->

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="modal-content">
                <h2>
                    ¿Estás seguro que deseas eliminar tu cuenta?
                </h2>

                <p>
                    Una vez que elimines tu cuenta, todos tus recursos y datos serán eliminados permanentemente.
                    Ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de forma definitiva.
                </p>

                <div class="form-group">
                    <InputLabel for="password" value="Contraseña" class="sr-only" />

                    <TextInput id="password" ref="passwordInput" v-model="form.password" type="password" @keyup.enter="deleteUser" />

                    <InputError :message="form.errors.password" />
                </div>

                <div class="modal-actions">
                    <SecondaryButton @click="closeModal" class="button-cancel button">
                        Cancelar
                    </SecondaryButton>

                    <DangerButton :class="{ 'disabled': form.processing }" :disabled="form.processing"
                        @click="deleteUser" class="button-delete button"> Eliminar cuenta
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>

</template>
