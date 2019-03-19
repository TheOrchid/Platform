import {Controller} from "stimulus";
import Cropper      from 'cropperjs';

export default class extends Controller {

    /**
     * @type {string[]}
     */

    static targets = [
        "source",
        "upload"
    ];

    /**
     *
     */
    connect() {
        let image = this.data.get('image');

        if (image) {
            this.element.querySelector('.picture-preview').src = image;
        } else {
            this.element.querySelector('.picture-preview').classList.add('none');
            this.element.querySelector('.picture-remove').classList.add('none');
        }

        let cropPanel = this.element.querySelector('.upload-panel');

        cropPanel.width = this.data.get('width');
        cropPanel.height = this.data.get('height');

        this.cropper = new Cropper(cropPanel, {
            aspectRatio: this.data.get('width') / this.data.get('height'),
        });
    }

    /**
     * Event for uploading image
     *
     * @param event
     */
    upload(event) {


        if (!event.target.files[0]) {
            $(this.element.querySelector('.modal')).modal('show');
            return;
        }


        let reader = new FileReader();
        reader.readAsDataURL(event.target.files[0]);

        reader.onloadend = () => {
            this.cropper.replace(reader.result)
        };

        $(this.element.querySelector('.modal')).modal('show');
    }

    /**
     *
     */
    openModal(event)
    {
        if (!event.target.files[0]) {
            return;
        }

        $(this.element.querySelector('.modal')).modal('show');
    }

    /**
     * Action on click button "Crop"
     */
    crop() {

        this.cropper.getCroppedCanvas({
            width: this.data.get('width'),
            height: this.data.get('height'),
            imageSmoothingQuality: 'medium'
        }).toBlob((blob) => {
            const formData = new FormData();

            formData.append('file', blob);
            formData.append('storage', this.data.get('storage'));

            let element = this.element;
            axios.post(platform.prefix('/systems/files'), formData)
                .then((response) => {
                    let image = response.data.url;

                    element.querySelector('.picture-preview').src = image;
                    element.querySelector('.picture-preview').classList.remove('none');
                    element.querySelector('.picture-remove').classList.remove('none');
                    element.querySelector('.picture-path').value = image;
                    $(element.querySelector('.modal')).modal('hide');
                });
        });

    }

    /**
     *
     */
    clear() {
        this.element.querySelector('.picture-path').value = '';
        this.element.querySelector('.picture-preview').src = '';
        this.element.querySelector('.picture-preview').classList.add('none');
        this.element.querySelector('.picture-remove').classList.add('none');
    }

    /**
     * Action on click buttons
     */
    moveleft() {
        this.cropper.move(-10, 0);
    }

    moveright() {
        this.cropper.move(10, 0);
    }

    moveup() {
        this.cropper.move(0, -10);
    }

    movedown() {
        this.cropper.move(0, 10);
    }

    zoomin() {
        this.cropper.zoom(0.1);
    }

    zoomout() {
        this.cropper.zoom(-0.1);
    }

    rotateleft() {
        this.cropper.rotate(-5);
    }

    rotateright() {
        this.cropper.rotate(5);
    }

    scalex() {
        var dataScaleX = this.element.querySelector('.picture-dataScaleX');
        this.cropper.scaleX(-dataScaleX.value);
    }

    scaley() {
        var dataScaleY = this.element.querySelector('.picture-dataScaleY');
        this.cropper.scaleY(-dataScaleY.value)
    }

    aspectratiowh() {
        this.cropper.setAspectRatio(this.data.get('width') / this.data.get('height'));
    }

    aspectratiofree() {
        this.cropper.setAspectRatio(NaN);
    }

}