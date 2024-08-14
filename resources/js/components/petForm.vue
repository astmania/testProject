<template>
    <div>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <main class="form-container">
                        <div class="form-cards">
                            <div class="form-ImgCard">
                                <div class="form-ImgSource" v-if="form.petAva == null">
                                    <img style="width: 57px;" src="http://127.0.0.1:8000/uploads/photo.svg"
                                        alt="Выбранное изображение">
                                </div>
                                <div class="form-ImgSource d-flex" style="border-radius: 50%;"
                                    v-if="form.petAva != null">
                                    <img style="height:100%;" :src="imageUrl" alt="Выбранное изображение">

                                </div>

                                <input class="d-none" type="file" id="inputFile" @change="handleFileUpload">
                                <div class="form-btn" @click="getImg()">
                                    Загрузить фото
                                </div>

                            </div>
                            <input type="text" v-model="form.pet_name" placeholder="Индивидуальный номер животного"
                                class="form-input withMg">

                            </input>

                            <div class="form-selectt">
                                <label>
                                    Метод мечения:
                                </label>

                                <div class="form-selectLists">
                                    <button class="form-selectListsItem" v-for="item in form.petSelecting "
                                        @click="addPetsParams(item.id)">
                                        <div class="item-checkBox " :class="{ 'checked': item.status == true }">

                                        </div>
                                        <p class="item-title">
                                            {{ item.title }}
                                        </p>

                                    </button>


                                </div>

                            </div>


                            <input type="text" v-model="form.petMeterId" placeholder="Идентификатор прибора учета"
                                class="form-input withMg">

                            </input>


                            <input type="text" v-model="form.pet_nickname" placeholder="Кличка" class="form-input">

                            </input>


                        </div>
                        <div class="form-cards">
                            <label>Вид животного:</label>
                            <select v-model="form.selectedPetType" class="form-input withMg">
                                <option value="">Вид животного</option>
                                <option v-for="optionItem in form.petType " :key="optionItem.title"
                                    :value="optionItem.title">
                                    {{ optionItem.title }}
                                </option>
                            </select>
                            <!-- <p>Selected Pet Type: {{ form.selectedPetType }}</p> -->

                            <select v-model="form.selectedPetBreed" class="form-input withMg">
                                <option value="">Порода животного</option>
                                <option v-for="breed in filteredBreeds" :key="breed" :value="breed">
                                    {{ breed }}
                                </option>
                            </select>



                            <label style="margin-top: 10px;">Адрес животного:</label>
                            <input type="text" v-model="form.pet_region" placeholder="Область"
                                class="form-input withMg">
                            </input>
                            <input type="text" v-model="form.pet_district" placeholder="Район"
                                class="form-input withMg">
                            </input>
                            <input type="text" v-model="form.pet_locality" placeholder="Населенный пункт"
                                class="form-input withMg">
                            </input>
                            <label for="home_street">Бродячее/домашнее:</label>
                            <input type="checkbox" v-model="form.petHome" class="input_checker_attr withMg" name=""
                                id="home_street" style="pointer-events: all;">
                            <input type="text" v-model="form.pet_Id" placeholder="ИИН" class="form-input withMg">
                            </input>
                            <label for="home_street">Дата регистрации:</label>
                            <input type="date" v-model="form.petDateRegister" class="form-input withMg"> </input>
                        </div>
                        <div class="form-cards">
                            <label for="">Характеристики животного</label>
                            <input type="number" v-model="form.pet_weight" placeholder="Масса животного (гр)"
                                class="form-input withMg">
                            </input>
                            <input type="number" v-model="form.pet_height" placeholder="Высота животного в холке (мм)"
                                class="form-input withMg">
                            </input>
                            <label style="margin-top: 10px;">Возраст животного:</label>
                            <div class="d-flex g-16 withMg">
                                <div class="d-flex g-8 w-50">
                                    <input type="number" min="0" value="0" v-model="form.pet_age" class="form-input">
                                    </input>
                                    <label class="mg-0">Лет</label>
                                </div>
                                <div class="d-flex g-8 w-50">
                                    <input type="number" min="0" max="12" value="0" v-model="form.pet_ageMonth"
                                        class="form-input">
                                    </input>
                                    <label class="mg-0">Мес.</label>
                                </div>
                            </div>
                            <label for="">Особые приметы:</label>
                            <textarea name="" id="" class="withMg area_style" cols="30" rows="4"></textarea>
                            <label for="">Иные сведения:</label>
                            <textarea name="" id="" class="withMg area_style" cols="30" rows="4"></textarea>
                            <div class="d-flex sends_btn">
                                <button data-bs-dismiss="modal">Закрыть</button>
                                <button @click="store()">
                                    Готово
                                </button>
                            </div>
                        </div>

                    </main>
                </div>
            </div>
        </div>


        {{ form.petAva }}




    </div>
</template>

<script>

import axios from 'axios'

export default {
    data() {
        return {
            showModal: false,
            imageUrl: null,
            form: {
                petAva: null,
                pet_weight: '',
                pet_height: '',
                pet_age: '',
                pet_ageMonth: '',

                pet_name: '',
                pet_nickname: '',
                petMeterId: '',
                pet_type: '',
                chipset: '',
                pet_region: '',
                pet_country: '',
                pet_city: '',
                pet_street: false,
                iin: '',
                reg_date: '',
                comment: '',
                other_comment: '',
                photo: null, // Для хранения файла фотографии
                petSelecting: [
                    {
                        id: 1,
                        title: "Браслет",
                        status: false
                    },

                    {
                        id: 2,
                        title: "Шлейка",
                        status: false
                    },
                    {
                        id: 3,
                        title: "Клеймо",
                        status: false
                    },
                    {
                        id: 4,
                        title: "Ошейник",
                        status: false
                    },
                    {
                        id: 5,
                        title: "Бирка",
                        status: false
                    },
                    {
                        id: 6,
                        title: "Чип",
                        status: false
                    }
                ],
                petType: [
                    {
                        id: 1,
                        title: 'Dog',
                    },
                    {
                        id: 2,
                        title: 'Cat',
                    },
                    {
                        id: 3,
                        title: 'Bug',
                    },
                ],
                breeds: {
                    Dog: ['Beagle', 'Bulldog', 'Poodle'],
                    Cat: ['Siamese', 'Persian', 'Maine Coon'],
                    Bug: ['Ladybug', 'Beetle', 'Dragonfly']
                },
                petDateRegister: null,
                selectedPetBreed: '',
                selectedPetType: '',
                petHome: true,

                pet_district: '',
                pet_locality: '',
                pet_Id: 1,
            },
            editing: false,
            petId: null,
        };
    },
    computed: {
        filteredBreeds() {
            // Возвращаем список пород в зависимости от выбранного вида животного
            return this.form.breeds[this.form.selectedPetType] || [];
        }
    },
    methods: {

        getImg() {
            document.getElementById('inputFile').click();
        },
        handleFileUpload(event) {
            console.log(this.imageUrl)
            const file = event.target.files[0];
            if (file) {
                this.form.petAva = file;
                this.imageUrl = URL.createObjectURL(file); // Создание Object URL для отображения
            } else {
                this.form.petAva = null;
                this.imageUrl = null;
            }



        },
        updateBreeds() {
            // Очистка выбранной породы при изменении вида животного
            this.form.selectedPetBreed = '';
        },
        addPetsParams(id) {

            const petItem = this.form.petSelecting.find(pet => pet.id === id);

            // Если элемент найден, изменить его статус
            if (petItem) {
                petItem.status = !petItem.status; // Переключаем статус
                console.log(`Статус элемента с ID ${id} изменен на ${petItem.status}`);
            } else {
                console.log(`Элемент с ID ${id} не найден`);
            }

        },
        store() {

            const formData = new FormData();

            // Добавляем изображение в FormData
            if (this.form.petAva) {
                formData.append('photo', this.form.petAva);
            }

            // Добавляем остальные данные в FormData
            formData.append('chipset', this.form.petMeterId);
            formData.append('check_id', parseInt(this.form.pet_name));
            formData.append('pet_name', this.form.pet_nickname);
            formData.append('pet_type', this.form.selectedPetType);
            formData.append('pet_family_type', this.form.selectedPetBreed);
            formData.append('pet_region', this.form.pet_region);
            formData.append('pet_country', this.form.pet_district);
            formData.append('pet_city', this.form.pet_locality);
            formData.append('pet_street', this.form.petHome === true ? '1' : '0');

            formData.append('iin', (this.form.pet_Id).toString());
            formData.append('reg_date', this.form.petDateRegister);
            formData.append('gr', this.form.pet_weight);
            formData.append('mm', this.form.pet_height);
            formData.append('old_year', this.form.pet_age);
            formData.append('old_month', this.form.pet_ageMonth);
            formData.append('comment', this.form.comment);
            formData.append('other_comment', this.form.other_comment);

            // Логирование данных в консоль для проверки
            console.log([...formData]); // Отображаем данные FormData для проверки

            // Отправляем данные на сервер с использованием Axios
            axios.post('http://127.0.0.1:8000/api/api/pets', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    console.log('Данные успешно отправлены:', response.data);
                    // Действия после успешной отправки данных
                })
                .catch(error => {
                    console.error('Ошибка при отправке данных:', error.response.data);
                });

        },
        openModal() {
            this.showModal = true;
        },
        openForEdit(pet) {
            this.form = { ...pet };
            this.petId = pet.id;
            this.editing = true;
            this.showModal = true;
        },

        submitForm() {
            const formData = new FormData();

            // Добавляем данные формы
            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key]);
            });

            const method = this.editing ? 'put' : 'post';

            const url = this.editing ? "/api/pets/" + this.petId : "/api/pets";
            axios({
                method: method,
                url: url,
                data: formData,
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
                .then(() => {
                    this.$emit('refreshPets');
                    this.showModal = false;
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },
};
</script>