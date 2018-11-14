<template>
    <sui-table-body>
      <sui-table-row v-for="item, index in data" :key="index">
           <sui-table-cell v-for="value, i in item" :key="i">
              <TableStatus :status="value" v-if="i == 'status_pesanan'" />
              <p v-else>{{value}}</p>
           </sui-table-cell>
           <sui-table-cell v-if="edit != 0">
              <router-link :to="{name: edit, params: {id: item.id}}" class="ui edit labeled icon button">
                  {{labelEdit}} 
                  <i class="edit icon"></i>
              </router-link>
           </sui-table-cell>
           <sui-table-cell v-if="hapus != 0">

              <div class="ui delete labeled icon button" v-on:click="handleDelete(item.id)">
                  Hapus
                  <i class="trash icon"></i>
              </div>
           </sui-table-cell>
      </sui-table-row>
    </sui-table-body>
</template>

<style>
  .ui.delete.button, .ui.delete.buttons .button {
    background-color: #db2828;
    color: #fff;
    text-shadow: none;
    background-image: none;
  }
  .ui.edit.button, .ui.edit.buttons .button {
    background-color: #21ba45;
    color: #fff;
    text-shadow: none;
    background-image: none;    
  }
</style>

<script>
  import TableStatus from './TableStatus'
  export default {
    props: ["data","edit","labelEdit","hapus"],
    components: {
      TableStatus
    },
    methods: {
      handleDelete(id){
        const app = this
        app.$swal({
          text: `Anda Yakin Ingin Menghapus Data ini ?`,
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          willDelete ? app.$emit('delete',id) : app.$swal.close()
        })
      }
    }
  }
</script>
