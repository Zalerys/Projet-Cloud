const BackgroundStyle = (props: any) => {
  const setBackground = props.setBackground;

  return (
    <>
      {setBackground === 1 ? (
        <>
          <svg
            className="absolute bottom-0"
            id="visual"
            viewBox="0 0 900 600"
            xmlns="http://www.w3.org/2000/svg"
            version="1.1"
          >
            <path
              d="M0 538L129 513L257 528L386 524L514 527L643 549L771 537L900 513L900 601L771 601L643 601L514 601L386 601L257 601L129 601L0 601Z"
              fill="#867bff"
            ></path>
            <path
              d="M0 556L129 528L257 522L386 527L514 551L643 547L771 554L900 531L900 601L771 601L643 601L514 601L386 601L257 601L129 601L0 601Z"
              fill="#bc7ded"
            ></path>
            <path
              d="M0 550L129 549L257 561L386 538L514 545L643 556L771 534L900 539L900 601L771 601L643 601L514 601L386 601L257 601L129 601L0 601Z"
              fill="#dc85db"
            ></path>
            <path
              d="M0 546L129 557L257 563L386 569L514 558L643 552L771 561L900 567L900 601L771 601L643 601L514 601L386 601L257 601L129 601L0 601Z"
              fill="#ef92cd"
            ></path>
            <path
              d="M0 572L129 560L257 560L386 567L514 570L643 573L771 563L900 573L900 601L771 601L643 601L514 601L386 601L257 601L129 601L0 601Z"
              fill="#f8a3c4"
            ></path>
            <path
              d="M0 576L129 571L257 580L386 568L514 583L643 581L771 579L900 581L900 601L771 601L643 601L514 601L386 601L257 601L129 601L0 601Z"
              fill="#fab6c3"
            ></path>
            <path
              d="M0 580L129 589L257 587L386 580L514 585L643 589L771 587L900 585L900 601L771 601L643 601L514 601L386 601L257 601L129 601L0 601Z"
              fill="#f7caca"
            ></path>
          </svg>
        </>
      ) : setBackground === 2 ? (
        <div className="absolute top-0 w-full opacity-60">
          <svg
            id="visual"
            viewBox="0 0 900 600"
            xmlns="http://www.w3.org/2000/svg"
            version="1.1"
          >
            <defs>
              <filter id="blur1" x="-10%" y="-10%">
                <feBlend
                  mode="normal"
                  in="SourceGraphic"
                  in2="BackgroundImageFix"
                  result="shape"
                ></feBlend>
                <feGaussianBlur
                  stdDeviation="161"
                  result="effect1_foregroundBlur"
                ></feGaussianBlur>
              </filter>
            </defs>
            <rect fill="#be94fd"></rect>
            <g filter="url(#blur1)">
              <circle cx="118" cy="42" fill="#72fddb" r="357"></circle>
              <circle cx="359" cy="289" fill="#be94fd" r="357"></circle>
              <circle cx="757" cy="298" fill="#72fddb" r="357"></circle>
              <circle cx="418" cy="109" fill="#72fddb" r="357"></circle>
              <circle cx="518" cy="492" fill="#be94fd" r="357"></circle>
              <circle cx="188" cy="404" fill="#72fddb" r="357"></circle>
            </g>
          </svg>
        </div>
      ) : null}
    </>
  );
};

export default BackgroundStyle;
