import {
    INITIAL_STATUS,
    LOADING_STATUS,
    READY_STATUS,
    ERROR_STATUS,
} from "./constants";

export interface FilterFormInterface {
    name: string;
    price: null | Record<number, number>;
    bedrooms: null | number;
    bathrooms: null | number;
    storeys: null | number;
    garages: null | number;
}

export interface PropertyInterface extends Omit<FilterFormInterface, "price"> {
    price: null | number;
}

export type PropertiesType = PropertyInterface[];

export type StatusChangeType =
    | typeof INITIAL_STATUS
    | typeof LOADING_STATUS
    | typeof READY_STATUS
    | typeof ERROR_STATUS;

export interface PriceInterface {
    max: number;
    min: number;
    step: number;
}
