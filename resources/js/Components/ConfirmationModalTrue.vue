<template>
  
    <div class="modal">
      <div class="modal-content" >
        <p>{{ message }}</p>
        <div class="modal-buttons">
            <SecondaryButton @click="cancel" class=" mr-5">Cancelar</SecondaryButton>
            <PrimaryButton @click="confirm">Confirmar</PrimaryButton>
          
        </div>
      </div>
    </div>
    <div class="modal-overlay" @click="cancel"></div>
  
</template>
  
<script setup>
  

  import PrimaryButton from '@/Components/PrimaryButton.vue'
  import SecondaryButton from '@/Components/SecondaryButton.vue'
  
  const props = defineProps({
    message: {
      type: String,
      required: true,
    }
  });
 
  const emit = defineEmits(['confirm', 'cancel']);
  
  const  confirm = ()  => {
    emit('confirmed');
  }
  
  const cancel = ()  => {
    emit('canceled');
  }
  
</script>
  
<style scoped>
  .modal {
    position: fixed;
    z-index: 999;
  
    top: 0;
    left:0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .modal-content {
    
    background-color: rgb(255, 255, 255);
    padding: 25px;
    border-radius: 10px;
    
    
  }
  
  .modal-buttons {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
    background-color: rgb(255, 255, 255);
  }
</style>