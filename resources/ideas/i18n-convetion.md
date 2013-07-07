> par contre chaque segment se raporte au passé ou au futur ?
Comme la convention pour les commits d'AngularJS, présent de l'impératif, i.e. ce que fait/décrit l'objet decrit (requête, efface, liste, etc.)

> view : c'est la ou se trouve le i18n parmis les source, OU la page "Vue" qui s'affichera ?
C'est la vue/écran ou sous-partie de celle-ci. Ça permet d'avoir des clés génériques et réutilisables (error, profile, cli-error. footer, etc.)

> action : l'action qui nous amene ici OU celle qui se produira ?

Celle qui se produira lors de l'activation de l'élément (soumettre, valider, etc.)

# Namimg Convention

i18n should be build as follow: `[view].[action|property[:state]].[ui]`

## Segments

Each i18n key should be composed of 3 segments:
* `view`:
  * view –in <abbr title="Model-View-Controller">MVC</abbr> sense– in which the key appears ;
  * e.g.: _cli_, _logout_, _dashboard_, etc. ;
* `action|property`:
  * an action or a property of the current `view` ;
  * e.g.: _submit_, _username_, etc. ;
* `:state` (optionnal sub-segment):
  * state of the `action|property` ;
  * e.g.: _:success_, _:incomplete_, _:checked_ ;
* `ui`:
  * <abbr title="UI">UI</abbr> holding the string.
  Should help understand how the string will appear. For instance, a _header_ would not be rendered in the same way as a text's _label_ (the former should be shorter than the latter).
  * e.g.: _header_, _label_, _description_, _placeholder_, etc.

## Complexity and Granularity

If one of your segment need to express some complexity/granularity, always try to express yourself in a more simple way as _others people_ may not understand your reasoning.

If you **really** can't, and more granularity is needed, we recommend to use a `-` (dash) inside the segment of the i18n's key.


# Examples

## Basic: A section's header

    logout.request:success.header
Could refer to a `<section>` tag or a graphical area like a modal window (with header/body/footer).
* view: _logout_,
* action: _request_,
  * state: _success_,
* context: _header_.

## Using `property` (instead of `action`)

    install-dbms.username.label
Describe a `label` (in a form or elsewhere):
* view: _install-dbms_,
* property: _username_,
  * state: `none`,
* context: _label_.

## Same property different context

    install-dbms.username.placeholder
The key describe the `@placeholder` attribute of a field:
* view: _install-dbms_,
* property: _username_,
  * state: `none`,
* context: _placeholder_.

## Using placeholder

Placeholder for `printf` or `sprintf` should be placed between `[]` (brackets) after the most relevant segment:

    cli.CRC:incomplete-data[%s%s].error

# Commits

## New key

New i18n keys should be described as a `style` commit:

    style(i18n,$view): short description

## Conversion of old keys
Replacement from old i18n key to new (following this convention) must be described as a `refactor` commit:

    refactor(i18n,$view): replace old i18n key using convention
