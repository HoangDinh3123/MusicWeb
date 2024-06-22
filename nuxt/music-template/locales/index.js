import {AttributeText} from '~/locales/_attributes'
import {DefaultText} from '~/locales/_default'
import {userScreen} from "~/locales/_user";
import {MessageText} from "~/locales/_messages";
export const locale = {
    ...DefaultText.DEFAULT,
    ...userScreen.LABEL,
    ...MessageText,
    ...{
        ATTRIBUTE: {
            ...AttributeText.ATTRIBUTE,
            ...userScreen.ATTRIBUTE
        }
    }
}