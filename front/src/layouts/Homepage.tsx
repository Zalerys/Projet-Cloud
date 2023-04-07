import HomepageContent from "../containers/HomepageContent";
import Card from "../components/Card";

export default function Homepage() {
  return <div className="mx-16">
    <HomepageContent/>
    <div className="grid grid-cols-3 gap-10 mx-16 my-12">
      <Card/>
      <Card/>
      <Card/>
      <Card/>
    </div>
  </div>;
}
