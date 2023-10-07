<template>
    <div class="search">
        <el-container class="search__inner">
            <el-header class="search__header">
                <el-form
                    @submit.prevent="onSubmit"
                    :model="form"
                    class="search__form"
                >
                    <el-row :gutter="20" justify="center">
                        <el-col :span="10">
                            <el-input
                                v-model="form.name"
                                placeholder="Search..."
                            />
                        </el-col>
                    </el-row>
                    <el-row :gutter="20" justify="center">
                        <el-col :span="2">
                            <p>Bedrooms</p>
                            <el-select
                                v-model="form.bedrooms"
                                placeholder="Select"
                                :clearable="true"
                            >
                                <el-option
                                    v-for="item in getSelectOptions('bedrooms')"
                                    :key="item"
                                    :value="item"
                                />
                            </el-select>
                        </el-col>
                        <el-col :span="2">
                            <p>Bathrooms</p>
                            <el-select
                                v-model="form.bathrooms"
                                placeholder="Select"
                                :clearable="true"
                            >
                                <el-option
                                    v-for="item in getSelectOptions(
                                        'bathrooms'
                                    )"
                                    :key="item"
                                    :value="item"
                                />
                            </el-select>
                        </el-col>
                        <el-col :span="2">
                            <p>Storeys</p>
                            <el-select
                                v-model="form.storeys"
                                placeholder="Select"
                                :clearable="true"
                            >
                                <el-option
                                    v-for="item in getSelectOptions('storeys')"
                                    :key="item"
                                    :value="item"
                                />
                            </el-select>
                        </el-col>
                        <el-col :span="2">
                            <p>Garages</p>
                            <el-select
                                v-model="form.garages"
                                placeholder="Select"
                                :clearable="true"
                            >
                                <el-option
                                    v-for="item in getSelectOptions('garages')"
                                    :key="item"
                                    :value="item"
                                />
                            </el-select>
                        </el-col>
                        <el-col :span="2">
                            <p>Price</p>
                            <el-slider
                                v-model="form.price"
                                :min="price.min"
                                :max="price.max"
                                :step="price.step"
                                range
                                show-stops
                            />
                        </el-col>
                    </el-row>
                </el-form>
            </el-header>
            <el-main class="search__content">
                <el-scrollbar>
                    <el-alert
                        v-if="status === ERROR_STATUS"
                        title="error alert"
                        type="error"
                    />
                    <el-table
                        :data="tableData"
                        v-loading="status === LOADING_STATUS"
                    >
                        <el-table-column prop="name" label="Name" width="140" />
                        <el-table-column
                            prop="price"
                            label="Price"
                            width="120"
                        />
                        <el-table-column prop="bedrooms" label="Bedrooms" />
                        <el-table-column prop="bathrooms" label="Bathrooms" />
                        <el-table-column prop="storeys" label="Storeys" />
                        <el-table-column prop="garages" label="Garages" />
                    </el-table>
                </el-scrollbar>
            </el-main>
        </el-container>
    </div>
</template>

<script setup lang="ts">
import { reactive, ref, onMounted, watch, defineProps, PropType } from "vue";
import axios from "axios";
import { debounce } from "lodash";
import {
    INITIAL_STATUS,
    LOADING_STATUS,
    READY_STATUS,
    ERROR_STATUS,
} from "./constants";
import {
    FilterFormInterface,
    StatusChangeType,
    PropertiesType,
    PriceInterface,
} from "./types";

const props = defineProps({
    items: {
        type: Array as PropType<PropertiesType>,
        default: [],
    },
    price: {
        type: Object as PropType<PriceInterface>,
        required: true,
    },
});

const form = reactive<FilterFormInterface>({
    name: "",
    price: null,
    bedrooms: null,
    bathrooms: null,
    storeys: null,
    garages: null,
});
const tableData = ref<PropertiesType>([]);
const status = ref<StatusChangeType>(INITIAL_STATUS);

const onSubmit = async () => {
    try {
        const { data } = await axios.post("/api/properties", {
            ...form,
        });
        tableData.value = data;
        statusChange(READY_STATUS);
    } catch (error) {
        tableData.value = [];
        statusChange(ERROR_STATUS);
    }
};

const getSelectOptions = (key: string): number[] => {
    return props.items.reduce<number[]>((acc, prev) => {
        if (!acc.includes(prev[key])) {
            return [...acc, prev[key]];
        } else {
            return acc;
        }
    }, []);
};

const onFilterChange = debounce(() => {
    onSubmit();
}, 500);

const statusChange = (newStatus: StatusChangeType): void => {
    status.value = newStatus;
};

watch(form, () => {
    onFilterChange();
    statusChange(LOADING_STATUS);
});

onMounted(() => {
    tableData.value = props.items;
});
</script>
