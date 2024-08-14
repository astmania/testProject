<template>
    <pet-form @refreshPets="fetchPets" ref="petForm"></pet-form>

    <b-row>
        <b-col v-for="pet in pets" :key="pet.id" md="4">
            <b-card @click="editPet(pet)" :title="pet.pet_name">
                <b-card-img :src="pet.photoUrl" alt="Фото питомца"></b-card-img>
                <b-card-body>
                    <p class="card-text">Тип: {{ pet.pet_type }}</p>
                    <p class="card-text">Регион: {{ pet.pet_region }}</p>
                    <p class="card-text">Страна: {{ pet.pet_country }}</p>
                    <p class="card-text">Город: {{ pet.pet_city }}</p>
                </b-card-body>
            </b-card>
        </b-col>
    </b-row>
</template>

<script>
import PetForm from './petForm.vue';

export default {
    components: {
        PetForm,
    },
    data() {
        return {
            pets: [],
        };
    },
    methods: {
        fetchPets() {
            // axios.get('/api/pets')
            //     .then(response => {
            //         this.pets = response.data.map(pet => ({
            //             ...pet,
            //             photoUrl: pet.photo ? `${process.env.BASE_URL}/${pet.photo}` : null,
            //         }));
            //     })
            //     .catch(error => {
            //         console.error(error);
            //     });
        },
        editPet(pet) {
            this.$refs.petForm.openForEdit(pet);
        },
    },
    mounted() {
        this.fetchPets();
    },
};
</script>