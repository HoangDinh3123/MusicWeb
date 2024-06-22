export const useValidate = () => {
    const required = (value: string | null) => !!value

    const emailFormated = (value: string) => /^[a-z0-9!.#$%&*+_]+@[a-z0-9]+\.[a-z]{2,3}(?:\.[a-z]{2,3})?$/i.test(value)

    const isNumber = (value: any) => /^[0-9]+$/.test(value)

    const numberOnly = ($event: any) => {
        if(!isNumber($event.data)) {
            $event.preventDefault()
        }
    }

    const maxLength = (value: string, maxLength: number) => !value || value.length <= maxLength
    const minLength = (value: string, minLength: number) => !value || value.length >= minLength

    const notEmpty= (value: string | null) => !!value && value.replace(/\s+/, '').length > 0
    const noSpaceOnly = (value: string | null) => !value || value.replace(/\s+/, '').length > 0

    return {
        required,
        maxLength,
        minLength,
        notEmpty,
        noSpaceOnly,
        emailFormated,
        numberOnly,
    }
}